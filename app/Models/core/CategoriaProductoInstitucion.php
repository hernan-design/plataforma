<?php

/**
 * Modelo transaccional CategoriaProductoInstitucion, relaciona instituciones y categorias de productos.
 * @author Ayriel Noriega <ayrieltuproyecto@gmail.com>
 * @author Harold Rodríguez <hartuproyecto@gmail.com>
 */
namespace App;

use Illuminate\Database\Eloquent\Model;


class CategoriaProductoInstitucion extends Model {

	protected $table = 'core.categoria_producto_insti';

	protected $primaryKey = 'codigo_categoria_prod_insti';

	public $timestamps = false;

	/**
	 * Obtiene el nombre de la categoria del producto.
	 * @access public
	 * @return object CategoriaProducto&CategoriaProductoInstitucion
	 */
	public static function getCategoryProduct(int $id_category_insti)
	{
		$query = CategoriaProductoInstitucion::query();
		$query->join('core.categoria_producto as cp','cp.codigo_categoria_producto', '=', 'categoria_producto_insti.codigo_categoria_producto');
		$query->where('codigo_categoria_prod_insti', $id_category_insti);
		$data = $query->first();

		return $data;
    }

}
