<?php
require_once('./src/Utils.php');

class UtilsTest extends \PHPUnit\Framework\TestCase {

    public function testPassCheck() {
        $this->assertFalse(Utils::passCheck('Password'));
        $this->assertFalse(Utils::passCheck('1234567'));
        $this->assertFalse(Utils::passCheck('123456789'));
        $this->assertFalse(Utils::passCheck('Pass1!'));
        $this->assertFalse(Utils::passCheck('passw0rd'));

        $this->assertTrue(Utils::passCheck('Passw0rd!'));
        $this->assertTrue(Utils::passCheck('PASSw0RD!'));
        $this->assertTrue(Utils::passCheck('Password1.'));
        $this->assertTrue(Utils::passCheck('Password1!'));
        $this->assertTrue(Utils::passCheck('1Password!'));
    }
}
