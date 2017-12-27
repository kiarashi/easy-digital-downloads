<?php

/**
 * Discount Meta DB Tests
 *
 * @covers EDD_DB_Discount_Meta
 * @group edd_discounts_db
 * @group database
 * @group edd_discounts
 */
class Tests_Discount_Meta extends EDD_UnitTestCase {

	/**
	 * Discount object test fixture.
	 *
	 * @access protected
	 * @var    EDD_Discount
	 */
	protected $_discount;

	/**
	 * Discount ID.
	 *
	 * @access protected
	 * @var    int
	 */
	protected $_discount_id;

	/**
	 * Set up fixtures.
	 *
	 * @access public
	 */
	public function setUp() {
		parent::setUp();

		$this->_discount_id = EDD_Helper_Discount::create_simple_percent_discount();
		$this->_discount    = edd_get_discount( $this->_discount_id );
	}

	/**
	 * Run after each test to empty the cart and reset the test store.
	 *
	 * @access public
	 */
	public function tearDown() {
		self::_delete_all_data();

		parent::tearDown();
	}

	/**
	 * @covers EDD_DB_Discount_Meta::add_meta()
	 * @covers EDD_Discount::add_meta()
	 */
	public function test_add_metadata() {
		$this->assertFalse( $this->_discount->add_meta( '', '' ) );
		$this->assertNotEmpty( $this->_discount->add_meta( 'test_key', '' ) );
		$this->assertNotEmpty( $this->_discount->add_meta( 'test_key', '1' ) );
	}

	/**
	 * @covers EDD_DB_Discount_Meta::update_meta()
	 * @covers EDD_Discount::update_meta()
	 */
	public function test_update_metadata() {
		$this->assertEmpty( $this->_discount->update_meta( '', '' ) );
		$this->assertNotEmpty( $this->_discount->update_meta( 'test_key_2', '' ) );
		$this->assertNotEmpty( $this->_discount->update_meta( 'test_key_2', '1' ) );
	}

	/**
	 * @covers EDD_DB_Discount_Meta::get_meta()
	 * @covers EDD_Discount::get_meta()
	 */
	public function test_get_metadata() {
		$this->assertEmpty( $this->_discount->get_meta() );
		$this->assertEmpty( $this->_discount->get_meta( 'key_that_does_not_exist', true ) );
		$this->_discount->update_meta( 'test_key_2', '1' );
		$this->assertEquals( '1', $this->_discount->get_meta( 'test_key_2', true ) );
		$this->assertInternalType( 'array', $this->_discount->get_meta( 'test_key_2', false ) );
	}

	/**
	 * @covers EDD_DB_Discount_Meta::delete_meta()
	 * @covers EDD_Discount::delete_meta()
	 */
	public function test_delete_metadata() {
		$this->_discount->update_meta( 'test_key', '1' );
		$this->assertTrue( $this->_discount->delete_meta( 'test_key' ) );
		$this->assertFalse( $this->_discount->delete_meta( 'key_that_does_not_exist' ) );
	}
}