<?php

namespace App\Http\Data;

class TerminalData
{
    private string $name;

    /**
     * nameのセット
     * 
     * @param string $name
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * nameの取得
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
