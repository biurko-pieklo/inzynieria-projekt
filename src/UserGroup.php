<?php

declare(strict_types=1);

class UserGroup {
    public string $name;
    private array $users; 

    function __construct(string $name) {
        $this->setName($name);
    }

    /**
     * Returns name of the group
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Sets name of the group
     */
    public function setName(string $name): void {
        $this->name = $name;
    }

    /**
     * Returns users of the group
     */
    public function getUsers(): array {
        return $this->users;
    }

    /**
     * Adds user to the group
     */
    public function addUser(User $user): void {
        try {
            if ($user->getName()) {
                $this->users[] = $user;
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

}