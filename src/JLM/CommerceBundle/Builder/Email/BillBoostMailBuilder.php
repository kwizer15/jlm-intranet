<?php

/*
 * This file is part of the JLMCommerceBundle package.
 *
 * (c) Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JLM\CommerceBundle\Builder\Email;

use JLM\CommerceBundle\Pdf\Bill;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @author Emmanuel Bernaszuk <emmanuel.bernaszuk@kw12er.com>
 */
class BillBoostMailBuilder extends BillMailBuilder
{

    /**
     * {@inheritdoc}
     */
    public function buildSubject()
    {
        $this->setSubject('Relance facture n°'.$this->getBill()->getNumber());
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildBody()
    {
        $tot = $this->getBill()->getTotalPriceAti();
        $numbers = $this->getBill()->getNumber().' - '.$tot.' €';
        $this->setBody('Bonjour,'.chr(10).chr(10)
        .'Suite à nos relances restées sans réponse de votre part concernant la facture ci-jointe'
        .' dont le réglement ne nous est pas encore parvenue à ce jour et dont l\'échéance est '
        .'dépassée, le montant global restant à payer s\'élevant à : '.$tot.' €'.chr(10).chr(10)
        .'n°'.$numbers.chr(10).chr(10)
        .'Nous vous prions de nous faire parvenir ce règlement sous 72 heures, en cas de retard de paiement,'
        .' une indémnité légale forfaitaire pour frais de recouvrement de 40 € sera appliquée.'.chr(10).chr(10)
        .'Nous vous prions d\'agréer, Madame, Monsieur, l\'expression de nos salutations distinguées.'
        .$this->getSignature());
    }
    
    public function buildPreAttachements()
    {
        $name = 'uploads/FAC'.$this->getBill()->getNumber().'.pdf';
        Bill::save([$this->getBill()], true, $name);
        $file = new UploadedFile($name, 'FAC'.$this->getBill()->getNumber().'.pdf', 'application/pdf');
        $this->getMail()->addPreAttachement($file);
    }
}
