<?php namespace Cagartner\SQLAnywhere;

use Illuminate\Database\Connection;

class SQLAnywhereConnection extends Connection {

	/**
	 * Get the default query grammar instance.
	 *
	 * @return Illuminate\Database\Query\Grammars\Grammars\Grammar
	 */
	protected function getDefaultQueryGrammar()
	{
        return $this->withTablePrefix(new SQLAnywhereQueryGrammar);
	}

	/**
	 * Get the default schema grammar instance.
	 *
	 * @return Illuminate\Database\Schema\Grammars\Grammar
	 */
	protected function getDefaultSchemaGrammar()
	{
        return $this->withTablePrefix(new SQLAnywhereSchemaGrammar);
	}

}