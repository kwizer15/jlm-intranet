<?php

/*
 * This file is part of the JLMModelBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\ModelBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
abstract class UploadDocument
{
    /**
     * @var string
     */
    private $path;
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;
    
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }
    
    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }
    
    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    
    abstract protected function getUploadDir();
    
    public function preUpload()
    {
        if (null !== $this->file) {
            // nom unique
            $this->path = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
        }
    }
    
    public function upload()
    {
        // la propriété « file » peut être vide si le champ n'est pas requis
        if (null === $this->file) {
            return;
        }
        $this->file->move($this->getUploadRootDir(), $this->path);
        unset($this->file);
    }
    
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    /**
     * Set path
     *
     * @param string $path
     * @return UploadDocument
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * Get file
     *
     * @return file
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * Get file
     *
     * @param file $file
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }
}
