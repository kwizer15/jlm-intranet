<?php
namespace JLM\FeeBundle\Model;

use JLM\ContractBundle\Model\ContractInterface;
use JLM\CommerceBundle\Model\BillInterface;

interface FeeInterface
{
   
    /**
     * Ajoute un contrat à la redevance
     * @param ContractInterface $contract
     * @return self
     */
    public function addContract(ContractInterface $contract);
    
    /**
     * Retire un contrat de la redevance
     * @param ContractInterface $contract
     * @return self
     */
    public function removeContract(ContractInterface $contract);
    
    /**
     * Crée la facture de redevance
     * @param FeesFollowerInterface $follower
     * @param BillInterface $bill
     * @return BillInterface
     */
//  public function createBill(FeesFollowerInterface $follower, BillInterface $bill);
}
