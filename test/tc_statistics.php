<?php
class TcStatistics extends TcBase {

	function test(){
		$this->assertEquals(true,DBMOLE_COLLECT_STATISTICS);

		$dbmole = $this->pg;

		$this->assertStringContains("total queries: 3",$dbmole->getStatistics());

		$dbmole->selectInt("SELECT COUNT(*) FROM articles");

		$this->assertStringContains("total queries: 4",$dbmole->getStatistics());
	}
}
