<?php

/*
 * This file is part of the Genemu package.
 *
 * (c) Olivier Chauvel <olivier@generation-multiple.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\FormBundle\Gd\File;

use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;

use Genemu\Bundle\FormBundle\Gd\Gd;
use Genemu\Bundle\FormBundle\Gd\Filter\Crop;
use Genemu\Bundle\FormBundle\Gd\Filter\Rotate;
use Genemu\Bundle\FormBundle\Gd\Filter\Negate;
use Genemu\Bundle\FormBundle\Gd\Filter\Colorize;
use Genemu\Bundle\FormBundle\Gd\Filter\GrayScale;
use Genemu\Bundle\FormBundle\Gd\Filter\Blur;
use Genemu\Bundle\FormBundle\Gd\Filter\Opacity;

/**
 * @author Olivier Chauvel <olivier@generation-multiple.com>
 */
class Image extends File
{
    /**
     * @var null
     */
    protected $gd = null;

    /**
     * {@inheritdoc}
     */
    public function __construct($path, $checkPath = true)
    {
        parent::__construct($path, $checkPath);

        if (false === strpos($this->getMimeType(), 'image')) {
            throw new \RuntimeException(sprintf('Is not an image file. (%s)', $this->getMimeType()));
        }
    }

    /**
     * Check format image
     *
     * @param string $format
     *
     * @return string
     */
    public function checkFormat($format): string
    {
        $function = 'imagecreatefrom'.$format;

        if (!function_exists($function)) {
            return $this->checkFormat('jpeg');
        }

        return $format;
    }

    /**
     * Create thumbnail image
     *
     * @param string $name
     * @param int $width
     * @param int $height
     * @param int $quality
     *
     * @throws \Exception
     */
    public function createThumbnail($name, $width, $height, $quality = 90): void
    {
        $ext = $this->guessExtension();

        $path  = $this->getPath() . '/';
        $path .= $this->getBasename('.' . $ext) . $name;
        $path .= '.' . $ext;

        $thumbnail = $this->getGd()->createThumbnail($name, $path, $width, $height, $ext, $quality);

        $this->getGd()->setThumbnail($name, new Image($thumbnail->getPathname()));
    }

    /**
     * Search thumbnails
     *
     * @throws \Exception
     */
    public function searchThumbnails(): void
    {
        $thumbnails = array();

        $fileExt = $this->guessExtension();
        $fileName = $this->getBasename('.' . $fileExt);

        $files = new Finder();
        $files
            ->in($this->getPath())
            ->name($fileName . '*.' . $fileExt)
            ->notName($this->getFilename())
            ->files();

        foreach ($files as $file) {
            $file = new Image($file->getPathname());
            $thumbnail = preg_replace('/^' . $fileName . '(\w+)(.*)/', '$1', $file->getFilename());

            $thumbnails[$thumbnail] = $file;
        }

        $this->getGd()->setThumbnails($thumbnails);
    }

    /**
     * Get thumbnail
     *
     * @param string $name
     *
     * @return Image|null
     *
     * @throws \Exception
     */
    public function getThumbnail($name): ?Image
    {
        if (!$this->hasThumbnail($name)) {
            $this->searchThumbnails();
        }

        return $this->getGd()->getThumbnail($name);
    }

    /**
     * Get thumbnails
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getThumbnails(): array
    {
        if (!$this->getGd()->getThumbnails()) {
            $this->searchThumbnails();
        }

        return $this->getGd()->getThumbnails();
    }

    /**
     * Has thumbnail
     *
     * @param string $name
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function hasThumbnail($name): bool
    {
        if (!$this->getGd()->getThumbnails()) {
            $this->searchThumbnails();
        }

        return $this->getGd()->hasThumbnail($name);
    }

    /**
     * Add filter crop to image
     *
     * @param int $x
     * @param int $y
     * @param int $w
     * @param int $h
     *
     * @throws \Exception
     */
    public function addFilterCrop($x, $y, $w, $h): void
    {
        $this->getGd()->addFilter(new Crop($x, $y, $w, $h));
    }

    /**
     * Add filter rotate to image
     *
     * @param int $rotate
     *
     * @throws \Exception
     */
    public function addFilterRotate($rotate = 90): void
    {
        $this->getGd()->addFilter(new Rotate($rotate));
    }

    /**
     * Add filter negative to image
     *
     * @throws \Exception
     */
    public function addFilterNegative(): void
    {
        $this->getGd()->addFilter(new Negate());
    }

    /**
     * Add filter sepia to image
     *
     * @param string $color
     *
     * @throws \Exception
     */
    public function addFilterSepia($color): void
    {
        $this->getGd()->addFilters(array(
            new GrayScale(),
            new Colorize($color)
        ));
    }

    /**
     * Add filter gray scale to image
     *
     * @throws \Exception
     */
    public function addFilterBw(): void
    {
        $this->getGd()->addFilter(new GrayScale());
    }

    /**
     * Add filter blur to image
     *
     * @throws \Exception
     */
    public function addFilterBlur(): void
    {
        $this->getGd()->addFilter(new Blur());
    }

    /**
     * Add filter opacity to image
     *
     * @throws \Exception
     */
    public function addFilterOpacity($opacity): void
    {
        $this->getGd()->addFilter(new Opacity($opacity));
    }

    /**
     * Get gd manipulator
     *
     * @return \Genemu\Bundle\FormBundle\Gd\Gd
     *
     * @throws \Exception
     */
    public function getGd(): Gd
    {
        if (null === $this->gd) {
            $format = $this->checkFormat($this->guessExtension());
            $generate = 'imagecreatefrom' . $format;

            $this->gd = new Gd();
            $this->gd->setResource($generate($this->getPathname()));
        }

        return $this->gd;
    }

    /**
     * Get width
     *
     * @return int
     *
     * @throws \Exception
     */
    public function getWidth(): int
    {
        return $this->getGd()->getWidth();
    }

    /**
     * Get height
     *
     * @return int
     *
     * @throws \Exception
     */
    public function getHeight(): int
    {
        return $this->getGd()->getHeight();
    }

    /**
     * Get base64 image
     *
     * @return string
     *
     * @throws \Exception
     */
    public function getBase64(): string
    {
        return $this->getGd()->getBase64($this->guessExtension());
    }

    /**
     * Save image file
     *
     * @param int $quality
     *
     * @throws \Exception
     */
    public function save(int $quality = 90): void
    {
        $this->getGd()->save($this->getPathname(), $this->guessExtension(), $quality);
    }
}
