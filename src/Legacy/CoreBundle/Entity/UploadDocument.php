<?php

namespace JLM\CoreBundle\Entity;

use JLM\CoreBundle\Model\UploadDocumentInterface;

class UploadDocument implements UploadDocumentInterface
{
	/**
	 * @var int
	 */
    private $id;

    /**
     * @var string
     */
    private $path;
    
    /**
     * @var UploadedFile
     */
    private $file;

    public function getFile()
    {
    	return $this->file;
    }
    
    public function setFile($file)
    {
    	$this->file = $file;
    	
    	return $this;
    }
    
    /**
     * @return NULL|string
     */
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    /**
     * @return NULL|string
     */
    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    /**
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * @return string
     */
    protected function getUploadDir()
    {
        return 'uploads/documents';
    }
    
    public function preUpload()
    {
    	if (null !== $this->file) 
    	{
    		$this->path = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
    	}
    }
    
    public function upload()
    {
    	if (null === $this->file)
    	{
    		return;
    	}

    	$this->file->move($this->getUploadRootDir(), $this->path);
    
    	unset($this->file);
    }
    
    public function removeUpload()
    {
    	if ($file = $this->getAbsolutePath())
    	{
    		unlink($file);
    	}
    }
    
    public function __toString()
    {
    	return $this->getWebPath();
    }
}