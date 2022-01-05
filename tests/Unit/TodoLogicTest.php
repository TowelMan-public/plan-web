<?php

namespace Tests\Unit;

use App\Client\Response\TodoOnProjectResponse;
use App\Client\Response\TodoOnResponsibleResponse;
use App\Http\Data\TodoData;
use App\Http\Data\TodoDataNode;
use App\Logic\TodoLogic;
use App\Utility\DateUtility;
use DateTime;

class TodoLogicTest extends TestCase
{
    public function testCreateTodo_1()
    {
        //テストケース作成
        $startDate = DateUtility::getNextDaysTopDateTime(new DateTime());
        $finishDate = DateUtility::getNextDaysTopDateTime(new DateTime());

        $response = new TodoOnProjectResponse();
        $response->setTodoName('');
        $response->setTodoOnProjectId(1);
        $response->setIsCompleted(false);
        $response->setIsCopyContentsToUsers(false);
        $response->setStartDate(DateUtility::dateToString($startDate));
        $response->setFinishDate(DateUtility::dateToString($finishDate));

        //期待値作成
        $expected = new TodoData();
        $expected->setId(1);
        $expected->setName('');
        $expected->setIsCompleted(false);
        $expected->setIsOnProject(true);
        $expected->setStartDate($startDate);
        $expected->setFinishDate($finishDate);
        
        //実行
        $result = TodoLogic::createTodoData($response);

        //検証
        $this->assertEqualsTodoData($expected, $result);
    }

    public function testCreateTodo_2()
    {
        //テストケース作成
        $startDate = DateUtility::getNextDaysTopDateTime(new DateTime());
        $finishDate = DateUtility::getNextDaysTopDateTime(new DateTime());

        $response = new TodoOnResponsibleResponse();
        $response->setTodoName('');
        $response->setTodoOnProjectId(1);
        $response->setIsCompleted(false);
        $response->setTodoOnResponsibleId(2);
        $response->setStartDate(DateUtility::dateToString($startDate));
        $response->setFinishDate(DateUtility::dateToString($finishDate));

        //期待値作成
        $expected = new TodoData();
        $expected->setId(2);
        $expected->setName('');
        $expected->setIsCompleted(false);
        $expected->setIsOnProject(false);
        $expected->setStartDate($startDate);
        $expected->setFinishDate($finishDate);
        
        //実行
        $result = TodoLogic::createTodoData($response);

        //検証
        $this->assertEqualsTodoData($expected, $result);
    }

    public function testCreateTodoInDayData_1()
    {
        //テストケース
        $nowDate = DateUtility::createDate(2021, 1, 1, 10, 0);

        $todoData1 = new TodoData();
        $todoData1->setId(1);
        $todoData1->setName('test');
        $todoData1->setIsCompleted(false);
        $todoData1->setIsOnProject(false);
        $todoData1->setStartDate(DateUtility::createDate(2020, 12, 29, 20, 20));
        $todoData1->setFinishDate(DateUtility::createDate(2021, 1, 1, 6, 0));

        $todoData2 = new TodoData();
        $todoData2->setId(2);
        $todoData2->setName('test');
        $todoData2->setIsCompleted(false);
        $todoData2->setIsOnProject(false);
        $todoData2->setStartDate(DateUtility::createDate(2020, 12, 29, 20, 20));
        $todoData2->setFinishDate(DateUtility::createDate(2021, 1, 1, 7, 0));

        $todoData3 = new TodoData();
        $todoData3->setId(3);
        $todoData3->setName('test');
        $todoData3->setIsCompleted(false);
        $todoData3->setIsOnProject(false);
        $todoData3->setStartDate(DateUtility::createDate(2020, 12, 29, 20, 20));
        $todoData3->setFinishDate(DateUtility::createDate(2021, 1, 1, 9, 0));

        $todoData4 = new TodoData();
        $todoData4->setId(4);
        $todoData4->setName('test');
        $todoData4->setIsCompleted(false);
        $todoData4->setIsOnProject(false);
        $todoData4->setStartDate(DateUtility::createDate(2020, 12, 29, 20, 20));
        $todoData4->setFinishDate(DateUtility::createDate(2021, 1, 1, 11, 0));
        
        $todoData5 = new TodoData();
        $todoData5->setId(5);
        $todoData5->setName('test');
        $todoData5->setIsCompleted(false);
        $todoData5->setIsOnProject(false);
        $todoData5->setFinishDate(DateUtility::createDate(2021, 1, 1, 12, 0));
        $todoData5->setStartDate(DateUtility::createDate(2020, 12, 29, 20, 20));

        $todoData6 = new TodoData();
        $todoData6->setId(6);
        $todoData6->setName('test');
        $todoData6->setIsCompleted(false);
        $todoData6->setIsOnProject(false);
        $todoData6->setStartDate(DateUtility::createDate(2020, 12, 29, 20, 20));
        $todoData6->setFinishDate(DateUtility::createDate(2021, 1, 1, 13, 0));

        $todoData7 = new TodoData();
        $todoData7->setId(7);
        $todoData7->setName('test');
        $todoData7->setIsCompleted(false);
        $todoData7->setIsOnProject(false);
        $todoData7->setStartDate(DateUtility::createDate(2020, 12, 29, 20, 20));
        $todoData7->setFinishDate(DateUtility::createDate(2021, 1, 1, 20, 0));

        $todoData8 = new TodoData();
        $todoData8->setId(8);
        $todoData8->setName('test');
        $todoData8->setIsCompleted(false);
        $todoData8->setIsOnProject(false);
        $todoData8->setStartDate(DateUtility::createDate(2020, 12, 29, 20, 20));
        $todoData8->setFinishDate(DateUtility::createDate(2021, 1, 1, 21, 0));
        
        $todoData9 = new TodoData();
        $todoData9->setId(9);
        $todoData9->setName('test');
        $todoData9->setIsCompleted(false);
        $todoData9->setIsOnProject(false);
        $todoData9->setStartDate(DateUtility::createDate(2020, 12, 29, 20, 20));
        $todoData9->setFinishDate(DateUtility::createDate(2021, 1, 2, 1, 0));

        $todoData10 = new TodoData();
        $todoData10->setId(10);
        $todoData10->setName('test');
        $todoData10->setIsCompleted(false);
        $todoData10->setIsOnProject(false);
        $todoData10->setStartDate(DateUtility::createDate(2020, 12, 29, 20, 20));
        $todoData10->setFinishDate(DateUtility::createDate(2021, 1, 2, 2, 0));

        $todoDataArray = [
            $todoData9,
            $todoData1,
            $todoData10,
            $todoData3,
            $todoData2,
            $todoData4,
            $todoData6,
            $todoData8,
            $todoData5,
            $todoData7,
        ];

        //期待値作成
        $expiredTodoList = [
            $todoData1,
            $todoData2,
            $todoData3,
        ];

        $approachingTodoList = [
            $todoData4,
            $todoData5,
            $todoData6,
        ];

        $todaysTodoList = [
            $todoData7,
            $todoData8,
        ];

        $otherTodoList = [
            $todoData9,
            $todoData10,
        ];

        //実行
        $result = TodoLogic::createTodoInDayData($todoDataArray, $nowDate);

        //検証
        $this->assertEqualsTodoDataArray($result->getExpiredTodoList(), $expiredTodoList);
        $this->assertEqualsTodoDataArray($result->getApproachingTodoList(), $approachingTodoList);
        $this->assertEqualsTodoDataArray($result->getTodaysTodoList(), $todaysTodoList);
        $this->assertEqualsTodoDataArray($result->getOtherTodoList(), $otherTodoList);
    }

    public function testCreateTodoInMonth_1()
    {
        //テストケース
        $finishDate = DateUtility::createDate(2022, 1, 31, 0, 0);
        $todoOnProjectArray = [];
        $todoOnResponsibleArray = [];

        $todoOnProject = new TodoOnProjectResponse();
        $todoOnProject->setTodoOnProjectId(1);
        $todoOnProject->setTodoName('1');
        $todoOnProject->setStartDate(DateUtility::createDateString(2022, 1, 3, 20, 20));
        $todoOnProject->setFinishDate(DateUtility::createDateString(2022, 1, 5, 20, 20));
        $todoOnProject->setIsCompleted(true);
        $todoOnProjectArray[] = $todoOnProject;

        $todoOnProject = new TodoOnProjectResponse();
        $todoOnProject->setTodoOnProjectId(3);
        $todoOnProject->setTodoName('3');
        $todoOnProject->setStartDate(DateUtility::createDateString(2022, 1, 5, 20, 20));
        $todoOnProject->setFinishDate(DateUtility::createDateString(2022, 1, 5, 20, 20));
        $todoOnProject->setIsCompleted(true);
        $todoOnProjectArray[] = $todoOnProject;

        $todoOnResponsible = new TodoOnResponsibleResponse();
        $todoOnResponsible->setTodoOnResponsibleId(2);
        $todoOnResponsible->setTodoName('2');
        $todoOnResponsible->setIsCompleted(true);
        $todoOnResponsible->setStartDate(DateUtility::createDateString(2022, 1, 1, 20, 20));
        $todoOnResponsible->setFinishDate(DateUtility::createDateString(2022, 1, 4, 20, 20));
        $todoOnResponsibleArray[] = $todoOnResponsible;

        $todoOnResponsible = new TodoOnResponsibleResponse();
        $todoOnResponsible->setTodoOnResponsibleId(4);
        $todoOnResponsible->setTodoName('4');
        $todoOnResponsible->setIsCompleted(true);
        $todoOnResponsible->setStartDate(DateUtility::createDateString(2021, 12, 19, 20, 20));
        $todoOnResponsible->setFinishDate(DateUtility::createDateString(2022, 2, 2, 20, 20));
        $todoOnResponsibleArray[] = $todoOnResponsible;


        //期待値
        $year = 2022;
        $month = 1;
        $startWeek = 6;
        $finishDay = 31;

        $todoDataNodeArray = [];

        $node = new TodoDataNode(1, 0);
        $todoDataNodeArray[] = $node;

        $nextNode = new TodoDataNode();
        $nextNode->setIsEmpty(false);
        $nextNode->setId(4);
        $nextNode->setName('4');
        $nextNode->setIsCompleted(true);
        $nextNode->setIsOnProject(false);
        $nextNode->setStartDay(1);
        $nextNode->setDayLength(31);
        $nextNode->setBackNode($node);
        $node->setNextNode($nextNode);

        $node = new TodoDataNode(1, 0);
        $todoDataNodeArray[] = $node;

        $nextNode = new TodoDataNode();
        $nextNode->setIsEmpty(false);
        $nextNode->setId(2);
        $nextNode->setName('2');
        $nextNode->setIsCompleted(true);
        $nextNode->setIsOnProject(false);
        $nextNode->setStartDay(1);
        $nextNode->setDayLength(4);
        $nextNode->setBackNode($node);
        $node->setNextNode($nextNode);
        $node = $nextNode;

        $nextNode = new TodoDataNode();
        $nextNode->setIsEmpty(false);
        $nextNode->setId(3);
        $nextNode->setName('3');
        $nextNode->setIsCompleted(true);
        $nextNode->setIsOnProject(true);
        $nextNode->setStartDay(5);
        $nextNode->setDayLength(1);
        $nextNode->setBackNode($node);
        $node->setNextNode($nextNode);
        $node = $nextNode;

        $nextNode = new TodoDataNode(6, 26);
        $nextNode->setBackNode($node);
        $node->setNextNode($nextNode);

        $node = new TodoDataNode(1, 2);
        $todoDataNodeArray[] = $node;

        $nextNode = new TodoDataNode();
        $nextNode->setIsEmpty(false);
        $nextNode->setId(1);
        $nextNode->setName('1');
        $nextNode->setIsCompleted(true);
        $nextNode->setIsOnProject(true);
        $nextNode->setStartDay(3);
        $nextNode->setDayLength(3);
        $nextNode->setBackNode($node);
        $node->setNextNode($nextNode);
        $node = $nextNode;

        $nextNode = new TodoDataNode(6, 26);
        $nextNode->setBackNode($node);
        $node->setNextNode($nextNode);
        
        //実行
        $result = TodoLogic::createTodoInMonth($todoOnProjectArray, $todoOnResponsibleArray, $finishDate);

        //検証
        $this->assertSame($year, $result->getYear());
        $this->assertSame($month, $result->getMonth());
        $this->assertSame($finishDay, $result->getFinishDay());
        $this->assertSame($startWeek, $result->getStartWeek());
        $this->assertSameSize($todoDataNodeArray, $result->getTodoDataNodeArray());

        for($i = 0; $i < count($todoDataNodeArray); $i++){
            dump($i);
            $resultNode = $result->getTodoDataNodeArray()[$i];
            $expectedNode = $todoDataNodeArray[$i];

            while ($resultNode !== null) {
                dump($expectedNode, $resultNode);

                //比較              
                $this->assertSame($expectedNode->getIsEmpty(), $resultNode->getIsEmpty());
                $this->assertSame($expectedNode->getStartDay(), $resultNode->getStartDay());
                $this->assertSame($expectedNode->getDayLength(), $resultNode->getDayLength());
                
                if(!$resultNode->getIsEmpty()){
                    $this->assertSame($expectedNode->getIsCompleted(), $resultNode->getIsCompleted());
                    $this->assertSame($expectedNode->getIsOnProject(), $resultNode->getIsOnProject());
                    $this->assertSame($expectedNode->getName(), $resultNode->getName());
                    $this->assertSame($expectedNode->getId(), $resultNode->getId());  
                }

                //next
                $resultNode = $resultNode->getNextNode();
                $expectedNode = $expectedNode->getNextNode();
            }
        }
    }
}
