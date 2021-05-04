<?php

namespace App\Tests;

use App\Entity\Bank;
use App\Entity\Beneficiary;
use App\Entity\Transaction;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    public function testUserIsTrue()
    {
        $user = new User();
        $user->setmail('test@test.fr')
            ->setFirstname('testName')
            ->setLastName('testLastName')
            ->setPassword('password')
            ->setConfirmPassword('password');

        $this->assertTrue($user->getMail() === 'test@test.fr');
        $this->assertTrue($user->getFirstname() === 'testName');
        $this->assertTrue($user->getLastName() === 'testLastName');
        $this->assertTrue($user->getPassword() === 'password');
        $this->assertTrue($user->getConfirmPassword() === 'password');
    }

    public function testUserIsFalse()
    {
        $user = new User();
        $user->setmail('test@test.fr')
            ->setFirstname('testName')
            ->setLastName('testLastName')
            ->setPassword('password')
            ->setConfirmPassword('password');

        $this->assertFalse($user->getMail() === 'False@test.fr');
        $this->assertFalse($user->getFirstname() === 'FalseName');
        $this->assertFalse($user->getLastName() === 'FalseLastName');
        $this->assertFalse($user->getPassword() === 'Falsepassword');
        $this->assertFalse($user->getConfirmPassword() === 'Falsepassword');
    }

    public function testUserIsEmpty()
    {
        $user = new User();
        $this->assertEmpty($user->getMail());
        $this->assertEmpty($user->getFirstname());
        $this->assertEmpty($user->getLastName());
        $this->assertEmpty($user->getPassword());
        $this->assertEmpty($user->getConfirmPassword());
    }

    public function testBankIsTrue()
    {
        $userBank = new User();
        $bank = new Bank();
        $bank->setBankName('testBankName')
            ->setBankBalance(1500)
            ->setConnectAccount($userBank);           

        $this->assertTrue($bank->getBankName() === 'testBankName');
        $this->assertTrue($bank->getBankBalance() == 1500);
        $this->assertTrue($bank->getConnectAccount() === $userBank);
        
    }

    public function testBankIsFalse()
    {
        $userBank = new User();
        $bank = new Bank();
        $bank->setBankName('testBankName')
            ->setBankBalance(1500)
            ->setConnectAccount($userBank);           

        $this->assertFalse($bank->getBankName() === 'FalseBankName');
        $this->assertFalse($bank->getBankBalance() == 750);
        $this->assertFalse($bank->getConnectAccount() === $bank);
        
    }

    public function testBeneficiaryIsTrue()
    {
        $userBeneficiary = new User();
        $beneficiary = new Beneficiary();
        $beneficiary->setName('testNameBeneficiary')
            ->setLastName('testLastNameBeneficiary')
            ->setConnectUser($userBeneficiary);           

        $this->assertTrue($beneficiary->getName() === 'testNameBeneficiary');
        $this->assertTrue($beneficiary->getLastName() === 'testLastNameBeneficiary'); 
        $this->assertTrue($beneficiary->getConnectUser() === $userBeneficiary);        
    }

    public function testBeneficiaryIsFalse()
    {
        $userBeneficiary = new User();
        $beneficiary = new Beneficiary();
        $beneficiary->setName('testNameBeneficiary')
            ->setLastName('testLastNameBeneficiary')
            ->setConnectUser($userBeneficiary);           

        $this->assertFalse($beneficiary->getName() === 'FalseNameBeneficiary');
        $this->assertFalse($beneficiary->getLastName() === 'FalseNameBeneficiary'); 
        $this->assertFalse($beneficiary->getConnectUser() === $beneficiary);
        
    }

    public function testTransactionIsTrue()
    {
        $beneficiary = new Beneficiary();
        $bank = new Bank();
        $transaction = new Transaction();
        $transaction->setDescription('testTransaction')
        ->setDebit(500)
        ->setConnectBank($bank)
        ->setBeneficiaryTransaction($beneficiary);     

        $this->assertTrue($transaction->getDescription() === 'testTransaction');
        $this->assertTrue($transaction->getDebit() == 500); 
        $this->assertTrue($transaction->getConnectBank() === $bank);
        $this->assertTrue($transaction->getBeneficiaryTransaction() === $beneficiary);          
    }

    public function testTransactionIsFalse()
    {
        $beneficiary = new Beneficiary();
        $bank = new Bank();
        $transaction = new Transaction();
        $transaction->setDescription('testTransaction')
        ->setDebit(500)
        ->setConnectBank($bank)
        ->setBeneficiaryTransaction($beneficiary);     

        $this->assertFalse($transaction->getDescription() === 'FalseTransaction');
        $this->assertFalse($transaction->getDebit() == 800); 
        $this->assertFalse($transaction->getConnectBank() === $beneficiary);
        $this->assertFalse($transaction->getBeneficiaryTransaction() === $bank);          
    }




}
