<?php


class Sales_test extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->resetInstance();
    }

    public function test_index()
    {
//        $this->request->setCallable(function ($CI) {
//            echo 'ble ble ble ble ble ble ble ble';
//            echo $CI;
//        });

        $output = $this->request('GET', 'sales/index');
        var_dump($output);
        $this->assertContains('OSPOS', $output);
    }
}
