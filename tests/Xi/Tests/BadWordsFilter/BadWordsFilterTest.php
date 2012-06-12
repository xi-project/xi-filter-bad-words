<?php

namespace Xi\Tests\BadWordsFilter;

use Xi\BadWordsFilter\BadWordsFilter;

class BadWordsFilterTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var BadWordsFilter
     */
    private $filter;


    public function setUp()
    {
        $this->filter = new BadWordsFilter(ROOT_TESTS . '/evil-words-example.txt');
    }

    public function provideBadInputs()
    {
        return array(
            array('flower', 'donkeyfuckerlaalaa'),
            array('flower eating donkey flower', 'shit eating donkey fucker'),
            array('necropredating flower licking flower flower', 'necropredating ass licking cockmaster cunt'),
            array('flower flower', 'anal rapist'),
            array('Doctor Vesalas flower flower', 'Doctor Vesalas screw enema'),
            array('Shut your flower FACE flower', 'Shut your FuckIng FACE unclefucker'),
            array('Shut your flower FACE uncle flower', 'Shut your FuckIng FACE uncle fucker'),
            array("flower\n", "uncleFUCK3R\n"),
        );
    }


    /**
     * @test
     * @dataProvider provideBadInputs
     */
    public function filterShouldFilterBadWords($expected, $badInput)
    {
        $this->assertEquals($expected, $this->filter->filter($badInput));
    }


}
