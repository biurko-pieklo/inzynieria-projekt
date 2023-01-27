<?php
require_once('./src/User.php');

class UserTest extends \PHPUnit\Framework\TestCase {

    public function testDisplayNameWhenNoneProvided() {
        $user = new User('login', 'PassW0rd!', '');
        $this->assertSame($user->getLogin(), $user->getDisplayName());
    }
}
