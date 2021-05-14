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
     * Enable loop all folders.
     *
     * @return $this
     */
    public function loop(): Import {
        $this->loop = true;

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
     * Do and run import action.
     *
     * @return array
     */
    public function get(): array {
        $amp = Filer::extract(...$this->path)
            ->base($this->base)
            ->extensions('php');
        if ($this->loop) {
            $amp->loop();
        }
        if (!is_null($this->filter)) {
            $amp->filter($this->filter);
        }
        if ($this->duplicate) {
            $amp->duplicate();
        }
        return $amp->get();
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