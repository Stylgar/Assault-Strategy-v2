<?php

namespace W4f\GameBundle\Model;

use Doctrine\ORM\EntityManager;

class UnitOfWork {

    /**
     *
     * @var \Doctrine\ORM\EntityManager; 
     */
    protected $dbContext;

    public function __construct(EntityManager $manager)
    {
        $this->dbContext = $manager;
        $this->dbContext->getConnection()->beginTransaction(); // suspend auto-commit;
    }
    
    public function __destruct() {
        $this->dbContext->getConnection()->rollback();
    }
    
    /**
     * Returns the Doctrine Entity manager.
     * 
     * WARNING : This should not be used by controllers, because controllers must
     * know nothing of the database but when they have to save.
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getDbContext(){
        return $this->dbContext;
    }
    
    /**
     * This function is to be used by the controllers to save all the data in one blow
     * 
     * WARNING : No Action should use it, in order to guarantee transaction completeness
     */
    public function save(){
        try{
            $this->dbContext->flush();
            $this->dbContext->getConnection()->commit();
        } catch (Exception $ex) {
            $this->dbContext->getConnection()->rollback();
            throw $ex;
        }
        
    }
    
    
}
