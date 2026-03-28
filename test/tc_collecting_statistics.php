<?php
class TcCollectingStatistics extends TcBase {

	function test(){
		$this->assertEquals(true,DBMOLE_COLLECT_STATISTICS);

		$dbmole = $this->pg;

		$this->assertStringContains("total queries: 3",$dbmole->getStatistics());

		$dbmole->selectInt("SELECT COUNT(*) FROM test_table");

		$this->assertStringContains("total queries: 4",$dbmole->getStatistics());
	}
}
