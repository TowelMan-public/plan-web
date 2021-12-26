<?php

namespace Tests\Unit;

use App\Http\Data\TodoData;
use Closure;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase{

    /**
     * TodoDataについて、イコールかどうかを検証する
     *
     * @param TodoData $expected
     * @param TodoData $result
     * @return void
     */
    protected function assertEqualsTodoData(TodoData $expected, TodoData $result)
    {
        dump($expected, $result);
        $this->assertSame($expected->getId(), $result->getId());
        $this->assertSame($expected->getName(), $result->getName());
        $this->assertSame($expected->getIsCompleted(), $result->getIsCompleted());
        $this->assertSame($expected->getIsOnProject(), $result->getIsOnProject());
        $this->assertSame($expected->getStartDate()->getTimestamp(), $result->getStartDate()->getTimestamp());
        $this->assertSame($expected->getFinishDate()->getTimestamp(), $result->getFinishDate()->getTimestamp());
    }

    /**
     * TodoDataの配列について、イコールかどうかを検証する
     *
     * @param array $expectedArray
     * @param array $resultArray
     * @return void
     */
    protected function assertEqualsTodoDataArray(array $expectedArray, array $resultArray)
    {
        $this->baseAssertEqualsArray($expectedArray, $resultArray, function(TodoData $expected, TodoData $result){
            $this->assertEqualsTodoData($expected, $result);
        });
    }

    /**
     * 本クラス内で、配列が等しいかを調べる検証関数のベース。 
     *
     * @param array $expectedArray
     * @param array $resultArray
     * @param Closure $assertEqualsFanction function($expected, $result){ //検証 } の形式
     * @return void
     */
    private function baseAssertEqualsArray(array $expectedArray, array $resultArray, Closure $assertEqualsFanction)
    {
        //データの個数取得
        $expectedArrayCount = count($expectedArray);
        $resultarrayCount = count($resultArray);

        $this->assertSame($expectedArrayCount, $resultarrayCount);

        for($i = 0; $i < $expectedArrayCount; $i++){
            $assertEqualsFanction($expectedArray[$i], $resultArray[$i]);
        }
    }
}