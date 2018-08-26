<?php
//
//namespace JLM\OfficeBundle\Entity;
//
//use JLM\OfficeBundle\Entity\Ask;
//use Symfony\Component\Validator\Constraints as Assert;
//use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\HttpFoundation\File\UploadedFile;
//use JLM\ModelBundle\Entity\Door;
//use JLM\OfficeBundle\Entity\Quote;
//use JLM\DailyBundle\Entity\Intervention;
//
///**
// * Demande de contrat
// * JLM\OfficeBundle\Entity\AskContract
// *
// * @ORM\Table(name="askcontract")
// * @ORM\Entity(repositoryClass="JLM\OfficeBundle\Entity\AskContractRepository")
// */
//class AskContract extends Ask
//{
//  /**
//   * @ORM\Id
//   * @ORM\Column(type="integer")
//   * @ORM\GeneratedValue(strategy="AUTO")
//   */
//  private $id;
//
//  /**
//   * Propositions de contrat
//   * @ORM\OneToMany(targetEntity="ProposalContract",mappedBy="ask")
//   */
//  private $proposals;
//
//  /**
//   * Get Id
//   * @return int
//   */
//  public function getId()
//  {
//      return $this->id;
//  }
//
//  /**
//   * Dossier de stockage des documents uploadés
//   */
//  protected function getUploadDir()
//  {
//      return 'uploads/documents/askcontract';
//  }
//
//    /**
//     * Constructor
//     */
//    public function __construct()
//    {
//        $this->proposals = new \Doctrine\Common\Collections\ArrayCollection();
//    }
//
//    /**
//     * Add proposal
//     *
//     * @param \JLM\OfficeBundle\Entity\Proposal $proposal
//     * @return AskContract
//     */
//    public function addProposal(\JLM\OfficeBundle\Entity\Proposal $proposal)
//    {
//        $this->proposals[] = $proposal;
//
//        return $this;
//    }
//
//    /**
//     * Remove proposal
//     *
//     * @param \JLM\OfficeBundle\Entity\Proposal $proposal
//     */
//    public function removeQuote(\JLM\OfficeBundle\Entity\Proposal $proposal)
//    {
//        $this->proposals->removeElement($proposal);
//    }
//
//    /**
//     * Get proposals
//     *
//     * @return \Doctrine\Common\Collections\Collection
//     */
//    public function getProposals()
//    {
//        return $this->proposals;
//    }
//}
