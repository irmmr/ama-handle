<?php
/**
 * The package import class.
 * The package import handler for ama.
 * @author irmmr <irmmr.ir@gmail.com>
 * @version 1.0
 */
namespace Irmmr\Handle\Package;

use Irmmr\Handle\Data;
use Irmmr\Handle\Filer;

/**
 * Class Import
 * @package Irmmr\Handle\Package
 */
class Import
{
    /**
     * Import all types.
     */
    public const REQUIRE        = 'require';
    public const REQUIRE_ONCE   = 'require_once';
    public const INCLUDE        = 'include';
    public const INCLUDE_ONCE   = 'include_once';

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
     * All path imported.
     *
     * @var array
     */
    private $imported = [];

    /**
     * All files for import.
     *
     * @var array
     */
    private $files = [];

    /**
     * Return require values.
     *
     * @var bool
     */
    private $return = false;

    /**
     * Duplicate files status.
     *
     * @var bool
     */
    private $duplicate = false;

    /**
     * Filter function for user.
     *
     * @var null
     */
    private $filter = null;


    /**
     * The import type.
     *
     * @var string
     */
    private $type = self::REQUIRE;

    /**
     * Import constructor.
     *
     * @param string ...$path
     */
    public function __construct(string ...$path) {
        $this->path = $path;
    }

    /**
     * Set the import base.
     *
     * @param string ...$path
     * @return $this
     */
    public function base(string ...$path): Import {
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
    public function filter(callable $func): Import {
        $this->filter = $func;

        return $this;
    }

    /**
     * Remove duplicate files.
     *
     * @return $this
     */
    public function duplicate(): Import {
        $this->duplicate = true;

        return $this;
    }

    /**
     * Import type.
     *
     * @param string $type
     * @return $this
     */
    public function type(string $type): Import {
        $this->type = $type;

        return $this;
    }

    /**
     * Import return value.
     *
     * @return $this
     */
    public function return(): Import {
        $this->return = true;

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
     * Add a path to imported files.
     *
     * @param string $path
     * @param $data
     */
    private function addImported(string $path, $data): void {
        $path = substr($path, strlen($this->base));
        $this->imported[$path] = $data;
    }

    /**
     * Clean string path.
     *
     * @param string $path
     * @return string
     */
    private function cleanPath(string $path): string {
        return str_replace(['\\', '//'], '/', $path);
    }

    /**
     * Check if file ext is php.
     *
     * @param string $path
     * @return bool
     */
    private function isPhpFile(string $path): bool {
        return pathinfo($path, PATHINFO_EXTENSION) == 'php';
    }

    /**
     * Check if a file is importable.
     *
     * @param string $path
     * @return bool
     */
    private function isImportable(string $path): bool {
        return Filer::isFileExists($path) && $this->isPhpFile($path);
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
            $file = $this->pathBuilder([$dir, $file]);
            if ($this->isImportable($file)) {
                $this->files[] = $this->cleanPath($file);
            } elseif (Filer::isDirExists($file)) {
                $this->extractFiles($file);
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
            if ($this->isImportable($p)) {
                $this->files[] = $this->cleanPath($p);
            } elseif (Filer::isDirExists($p)) {
                $this->extractFiles($p);
            }
        }
    }

    /**
     * Do and run import action.
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

    /**
     * Import files that user defined.
     *
     * @return array
     */
    public function do(): array {
        $files = $this->get();
        if (empty($files)) {
            return [];
        }
        if ($this->type == self::REQUIRE) {
            foreach ($files as $file) {
                $ret = require "{$file}";
                if ($this->return) {
                    $this->addImported($file, $ret);
                }
            }
        } elseif ($this->type == self::REQUIRE_ONCE) {
            foreach ($files as $file) {
                $ret = require_once "{$file}";
                if ($this->return) {
                    $this->addImported($file, $ret);
                }
            }
        } elseif ($this->type == self::INCLUDE) {
            foreach ($files as $file) {
                $ret = include "{$file}";
                if ($this->return) {
                    $this->addImported($file, $ret);
                }
            }
        } elseif ($this->type == self::INCLUDE_ONCE) {
            foreach ($files as $file) {
                $ret = include_once "{$file}";
                if ($this->return) {
                    $this->addImported($file, $ret);
                }
            }
        }
        return $this->imported;
    }
}