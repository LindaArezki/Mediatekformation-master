<?php

namespace App\Tests;

use App\Entity\Formation;
use PHPUnit\Framework\TestCase;

/**
 * Description of FormationTest
 *
 * @author linda
 */
class FormationTest extends TestCase {
    
    public function testGetPublishedAtString(){
        $formation = new Formation();
        $formation->setPublishedAt(new \DateTime("2022-12-11"));
        $this->assertEquals("11/12/2022", $formation->getPublishedAtString());
    }
}
