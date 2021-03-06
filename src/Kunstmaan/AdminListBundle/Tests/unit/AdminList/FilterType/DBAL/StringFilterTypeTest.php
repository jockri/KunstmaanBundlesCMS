<?php

namespace Kunstmaan\AdminListBundle\Tests\AdminList\FilterType\DBAL;

use Kunstmaan\AdminListBundle\AdminList\FilterType\DBAL\StringFilterType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2012-09-26 at 13:21:33.
 */
class StringFilterTypeTest extends BaseDbalFilterTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var StringFilterType
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new StringFilterType('string', 'e');
    }

    public function testBindRequest()
    {
        $request = new Request(array('filter_comparator_string' => 'equals', 'filter_value_string' => 'TheStringValue'));

        $data = array();
        $uniqueId = 'string';
        $this->object->bindRequest($request, $data, $uniqueId);

        $this->assertEquals(array('comparator' => 'equals', 'value' => 'TheStringValue'), $data);
    }

    /**
     * @param string $comparator  The comparator
     * @param string $whereClause The where clause
     * @param mixed  $value       The value
     * @param mixed  $testValue   The test value
     *
     * @dataProvider applyDataProvider
     */
    public function testApply($comparator, $whereClause, $value, $testValue)
    {
        $qb = $this->getQueryBuilder();
        $qb->select('*')
            ->from('entity', 'e');
        $this->object->setQueryBuilder($qb);
        $this->object->apply(array('comparator' => $comparator, 'value' => $value), 'string');

        $this->assertEquals("SELECT * FROM entity e WHERE e.string $whereClause", $qb->getSQL());
        $this->assertEquals($testValue, $qb->getParameter('var_string'));
    }

    /**
     * @return array
     */
    public static function applyDataProvider()
    {
        return array(
            array('equals', '= :var_string', 'AStringValue1', 'AStringValue1'),
            array('notequals', '<> :var_string', 'AStringValue2', 'AStringValue2'),
            array('contains', 'LIKE :var_string', 'AStringValue3', '%AStringValue3%'),
            array('doesnotcontain', 'NOT LIKE :var_string', 'AStringValue4', '%AStringValue4%'),
            array('startswith', 'LIKE :var_string', 'AStringValue5', 'AStringValue5%'),
            array('endswith', 'LIKE :var_string', 'AStringValue6', '%AStringValue6'),
        );
    }

    public function testGetTemplate()
    {
        $this->assertEquals('KunstmaanAdminListBundle:FilterType:stringFilter.html.twig', $this->object->getTemplate());
    }
}
