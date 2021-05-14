<?php
/**
 * The files and folders extract.
 * The filer main extract of files and dirs.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Filer;

use Irmmr\Handle\Data;
use Irmmr\Handle\Filer;

/**
 * Class Extract
 * @package Irmmr\Handle\Filer
 */
class Extract
{
    /**
     * The import base path.
     *
     * @var string
     */
    private $base = '/';

    /**
     * All path addresses.
     *
     * @var array
     */
    private $path = [];

    /**
     * All files for import.
     *
     * @var array
     */
    private $files = [];

    /**
     * Duplicate files status.
     *
     * @var bool
     */
    private $duplicate = false;

    /**
     * Loop all folders in a folder.
     *
     * @var bool
     */
    private $loop = false;

    /**
     * Filter function for user.
     *
     * @var null
     */
    private $filter = null;

    /**
     * File valid extensions.
     *
     * @var array
     */
    private $extensions = [];

    /**
     * Import constructor.
     *
     * @param array $path
     */
    public function __construct(array $path) {
        $this->path = $path;
    }

    /**
     * Set the import base.
     *
     * @param string ...$path
     * @return $this
     */
    public function base(string ...$path): Extract {
        $pathBg = $this->pathBuilder($path);
        $pathBg = str_replace(['\\', '//'], '/', $pathBg);
        if (!Data::check()->endsWith($pathBg, '/')) {
            $pathBg .= '/';
        }
        $this->base = $pathBg;

        return $this;
    }

    /**
     * Filter imported files.
     *
     * @param callable $func
     * @return $this
     */
    public function filter(callable $func): Extract {
        $this->filter = $func;

        return $this;
    }

    /**
     * Add and set file extensions.
     *
     * @param   string ...$extension
     * @return  $this
     */
    public function extensions(string ...$extension): Extract {
        foreach ($extension as $ext) {
            if (!in_array($ext, $this->extensions)) {
                $this->extensions[] = $ext;
            }
        }

        return $this;
    }

    /**
     * Remove duplicate files.
     *
     * @return $this
     */
    public function duplicate(): Extract {
        $this->duplicate = true;

        return $this;
    }

    /**
     * Enable loop all folders.
     *
     * @return $this
     */
    public function loop(): Extract {
        $this->loop = true;

        return $this;
    }

    /**
     * Path builder with /.
     *
     * @param array $path
     * @return string
     */
    private function pathBuilder(array $path): string {
        return implode('/', $path);
    }

    /**
     * Clean string path.
     *
     * @param string $path
     * @return string
     */
    private function cleanPath(string $path): string {
        return str_replace(['\\', '//', '/./'], '/', $path);
    }

    /**
     * Check if file ext is php.
     *
     * @param string $path
     * @return bool
     */
    private function isValidExt(string $path): bool {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        return empty($this->extensions) || in_array($ext, $this->extensions);
    }

    /**
     * Check if a file is importable.
     *
     * @param string $path
     * @return bool
     */
    private function isValid(string $path): bool {
        return Filer::isFileExists($path) && $this->isValidExt($path);
    }

    /**
     * Extract all files from dir.
     *
     * @param string $dir
     * @return void
     */
    private function extractFiles(string $dir): void {
        $scan   = Filer::dir()->list($dir);
        foreach ($scan as $file) {
            $file = $this->cleanPath($this->pathBuilder([$dir, $file]));
            if ($this->isValid($file)) {
                $this->files[] = $file;
            } elseif ($this->loop && Filer::isDirExists($file)) {
                $this->extractFiles($file);
            }
        }
    }

    /**
     * Extract all file using format.
     *
     * @param string $path
     * @return void
     */
    private function glob(string $path): void {
        $scan   = @glob($path);
        if (!is_array($scan)) {
            return;
        }
        foreach ($scan as $file) {
            $file = $this->cleanPath($file);
            if ($this->isValid($file)) {
                $this->files[] = $file;
            }
        }
    }

    /**
     * Get all files.
     *
     * @param array $path
     */
    private function getFiles(array $path): void {
        if (empty($path)) {
            return;
        }
        foreach ($path as $p) {
            if ($this->isValid($p)) {
                $this->files[] = $this->cleanPath($p);
            } elseif (Data::check()->includes($p, '*')) {
                $this->glob($p);
            } elseif (Filer::isDirExists($p)) {
                $this->extractFiles($p);
            }
        }
    }

    /**
     * Get and extract all files.
     *
     * @return array
     */
    public function get(): array {
        $list       = [];
        // manage all files with original path.
        foreach ($this->path as $p) {
            $des = $this->pathBuilder([$this->base, $p]);
            $list[] = $des;
        }
        $this->getFiles($list);
        if (!is_null($this->filter)) {
            $this->files = array_filter($this->files, $this->filter);
        }
        // Duplicate files (!SORT_NUMERIC)
        if (!$this->duplicate) {
            $this->files = array_unique($this->files);
        }

        return $this->files;
    }
}