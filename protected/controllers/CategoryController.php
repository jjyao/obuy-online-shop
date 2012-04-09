<?php

class CategoryController extends Controller
{
	public function actionView()
	{
		if(isset($_GET['id']) && Category::isExist($_GET['id']))
		{
			$categoryId = $_GET['id'];
			$category = Category::model()->findByAttributes(array('id'=>$categoryId));
			$categories = Category::getSubCategories($categoryId);
			$categories[] = $categoryId;
			$onSale = Product::ON_SALE;

			// get newest products, hotest products and recommended products in current category
			$criteria = new CDbCriteria();
			$criteria->compare('isOnSale', Product::ON_SALE);
			$criteria->addInCondition('categoryId', $categories);
			$criteria->order = 'publishTime DESC';
			$criteria->limit = 8;
			$newestProducts = Product::model()->findAll($criteria);

			$categories = '(' . implode(',', $categories) . ')';
			$result = Yii::app()->db->createCommand(
				"SELECT o.productId productId FROM order_item o, product p WHERE o.productId = p.id AND 
				p.isOnSale = {$onSale} AND p.categoryId IN $categories GROUP BY o.productId ORDER BY count(o.id) DESC LIMIT 8")->query();
			$hotestProducts = array();
			foreach($result as $row)
			{
				$hotestProducts[] = Product::model()->findByPk($row['productId']);
			}

			$result = Yii::app()->db->createCommand(
						"SELECT e.productId productId FROM evaluation e, product p WHERE e.productId = p.id AND
						p.isOnSale = {$onSale} AND p.categoryId IN $categories GROUP BY e.productId ORDER BY avg(e.score) DESC LIMIT 8")->query();
			$recommendedProducts = array();
			foreach($result as $row)
			{
				$recommendedProducts[] = Product::model()->findByPk($row['productId']);
			}

			$this->render('view', array(
										'category'=>$category,
										'newestProducts'=>$newestProducts, 
									 	'hotestProducts'=>$hotestProducts,
									 	'recommendedProducts'=>$recommendedProducts,
									));
		}
		else
		{
			throw new CHttpException(404, '分类不存在');
		}
	}
}