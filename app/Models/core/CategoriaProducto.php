<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Cache, DB, Auth, Log, Input;

use App\Models;

use TuProyecto;

class CategoriaProducto extends Model {

	protected $table = 'core.categoria_producto';

	protected $primaryKey = 'codigo_categoria_producto';

	public $timestamps = false;

	public static function getCategories($validacion_categorias_marketplace = false)
	{
		$query = CategoriaProducto::query();
		$query->join('core.categoria_producto_insti', function($join) {
			$join->on('categoria_producto.codigo_categoria_producto', '=', 'categoria_producto_insti.codigo_categoria_producto')
				->where('categoria_producto_insti.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('categoria_producto_insti.codigo_estado', '=', Estado::getState('active'));
		});
		$query->orderby('nombre_categoria_producto','asc');
		$categories = $query->get();

		if(Auth::check() && RegistroSesion::institution()->validacion_categorias_marketplace && $validacion_categorias_marketplace) {
			$categories_marketplace = TipoPago::getCategoriasMarketplace();
			$categories = $categories->filter(function ($value) use ($categories_marketplace) {
				return in_array($value->codigo_cat_padre_producto, $categories_marketplace);
			});
		}

		return $categories->pluck('nombre_categoria_producto', 'codigo_categoria_prod_insti')->toArray();
	}

	public static function getFilterCategories($validacion_categorias_marketplace = false)
	{
		$query = CategoriaProducto::query();
		$query->select('categoria_producto.nombre_categoria_producto as text','categoria_producto_insti.codigo_categoria_prod_insti as id');
		$query->join('core.categoria_producto_insti', function($join) {
			$join->on('categoria_producto.codigo_categoria_producto', '=', 'categoria_producto_insti.codigo_categoria_producto')
				->where('categoria_producto_insti.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('categoria_producto_insti.codigo_estado', '=', Estado::getState('active'));
		});

		if(Input::has('q')){
			$query->whereRaw("categoria_producto.nombre_categoria_producto ilike '%".trim(Input::get('q'))."%'");
		}

		if(Input::has('dataId')){
			$query->where("categoria_producto_insti.codigo_categoria_prod_insti", '=', Input::get('dataId'));
		}
		$query->distinct();
		$query->orderby('text','asc');
		$categories = $query->get();

		if(Auth::check() && RegistroSesion::institution()->validacion_categorias_marketplace && $validacion_categorias_marketplace) {
			$categories_marketplace = TipoPago::getCategoriasMarketplace();
			$categories = $categories->filter(function ($value) use ($categories_marketplace) {
				return in_array($value->codigo_cat_padre_producto, $categories_marketplace);
			});
		}




		return $categories;
	}

	public static function getCategoryProduct($category)
	{
		return CategoriaProducto::where('url_categoria_producto', '=', strtolower(trim($category)))->first();
	}

	public static function getCategoriesList($register = null)
	{
		$categories = [];
		$query = CategoriaProducto::query();
		$query->select('categoria_producto.codigo_categoria_producto','categoria_producto_insti.codigo_categoria_prod_insti', 'nombre_categoria_producto','recom_producto_eval.codigo_categoria_producto as cod_categoria');
		$query->join('core.categoria_producto_insti', function($join) {
			$join->on('categoria_producto.codigo_categoria_producto', '=', 'categoria_producto_insti.codigo_categoria_producto')
				->where('categoria_producto_insti.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('categoria_producto_insti.codigo_estado', '=', Estado::getState('active'));
		});

		$query->join('core.recom_producto_eval', function($join) use($register){
			$join->on('recom_producto_eval.codigo_categoria_producto', '=', 'categoria_producto_insti.codigo_categoria_producto')
				->where('recom_producto_eval.codigo_registro_fase_usuario', '=', $register);
		});

		// Get total posts
		$query->orderby('codigo_categoria_prod_insti','asc');
		// Get posts
		return $query->get();

	}

	public static function getCategoriesListPdf($register = null)
	{
		$categories = [];
		$query = CategoriaProducto::query();
		$query->select('cat_padre_producto.nombre_cat_padre_producto');
		$query->join('core.categoria_producto_insti', function($join) {
			$join->on('categoria_producto.codigo_categoria_producto', '=', 'categoria_producto_insti.codigo_categoria_producto')
				->where('categoria_producto_insti.codigo_institucion', '=', RegistroSesion::getInstitution())
				->where('categoria_producto_insti.codigo_estado', '=', Estado::getState('active'));
		});

		$query->join('core.recom_producto_eval', function($join) use($register){
			$join->on('recom_producto_eval.codigo_categoria_producto', '=', 'categoria_producto_insti.codigo_categoria_producto')
				->where('recom_producto_eval.codigo_registro_fase_usuario', '=', $register);
		});

		$query->join('core.cat_padre_producto', 'cat_padre_producto.codigo_cat_padre_producto', '=', 'categoria_producto_insti.codigo_cat_padre_producto');

		// Get total posts
		$query->groupBy('cat_padre_producto.codigo_cat_padre_producto');
		// Get posts
		return $query->get();

	}

}
