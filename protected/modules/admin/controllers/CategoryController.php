<?php

class CategoryController extends AdminController
{

	public function filters()
	{
        return array(
            'accessControl',
        );
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * Create a new category
	 * This function should be called by ajax
	 * @param $_POST['parentId'] specify the parent category
	 */
	public function actionCreate()
	{
		// only respond to ajax request
		if(Yii::app()->request->isAjaxRequest)
		{
			$parentId = $_POST['parentId'];
			if($parentId == 'null')
			{
				$parentId = null;
			}
			if($parentId == null ||  $this->is_exist($parentId))
			{
				$category = new Category();
				$category->name = '新分类';
				$category->parentCategoryId = $parentId;
				$category->save();

				$result = array();
				$result['id'] = $category->id;
				$result['text'] = $category->name;
				echo json_encode($result);
			}
			else
			{
				header("HTTP/1.0 404 Category Not Found " . $parentId);
			}
		}
	}

	/**
	 * Delete a new category
	 * This function should be called by ajax
	 * @param $_POST['categoryId'] specify the category
	 * @param $_POST['isCascade'] specify whether sub categories should be deleted
	 */
	public function actionDelete()
	{
		// only respond to ajax request
		if(Yii::app()->request->isAjaxRequest)
		{
			$categoryId = $_POST['categoryId'];
			$isCascade = $_POST['isCascade'];

			if($this->is_exist($categoryId))
			{
				$category = Category::model()->findByAttributes(array('id'=>$categoryId));
				if(!empty($category->products)) // there are products that depend on this category
				{
					header("HTTP/1.0 404 该分类下有商品，无法删除");
				}
				else
				{
					if($isCascade == 'true')
					{					
						$category->delete(); // default is cascade
					}
					else
					{
						$parentId = $category->parentCategoryId;
						foreach($category->subCategories as $subCategory)
						{
							$subCategory->parentCategoryId = $parentId;
							$subCategory->save();
						}
						$category->delete(); // all childs have changed their parent, so no child will be removed 
					}
				}
			}
			else
			{
				header("HTTP/1.0 404 Category Not Found " . $categoryId);
			}
		}
	}

	/**
	 * Update the name of category
	 * This function should be called by ajax
	 * @param $_POST['categoryId'] specify the category
	 * @param $_POST['name'] specify the new name
	 */
	public function actionUpdate()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$categoryId = $_POST['categoryId'];
			$name = $_POST['name'];

			if($this->is_exist($categoryId))
			{
				$category = Category::model()->findByAttributes(array('id'=>$categoryId));
				if($name != '')
				{
					$category->name = $name;
					$category->save();
				}
				else
				{
					header("HTTP/1.0 406 Category name can't be empty");
				}
			}
			else
			{
				header("HTTP/1.0 404 Category Not Found " . $categoryId);
			}
		}
	}

	/**
	 * move the category, change it's parent
	 * This function should be called by ajax
	 * @param $_POST['sourceId'] specify the source category
	 * @param $_POST['targetId'] specify the target category
	 * @param $_POST['point'] indicate the drop operation, posible values are: 'append','top' or 'bottom'
	 */
	public function actionMove()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			$sourceId = $_POST['sourceId'];
			$targetId = $_POST['targetId'];
			$point = $_POST['point'];

			if($this->is_exist($sourceId) && $this->is_exist($targetId))
			{
				$sourceCategory = Category::model()->findByAttributes(array('id'=>$sourceId));
				$targetCategory = Category::model()->findByAttributes(array('id'=>$targetId));
				
				if($point == 'append') // now source should be the child of target
				{
					// TODO need check whether source actually can append to target, prevent cycle
					$sourceCategory->parentCategoryId = $targetCategory->id;
					$sourceCategory->save();
				}
				else
				{
					// only when source and target are not siblings, the movement is meaningful
					if($sourceCategory->parentCategoryId != $targetCategory->parentCategoryId)
					{
						if($point == 'top' || $point == 'bottom') // now source should be the sibling of target
						{
							// TODO need check whether source can be the sibling of target, prevent cycle
							$sourceCategory->parentCategoryId = $targetCategory->parentCategoryId;
							$sourceCategory->save();
						}
						else
						{
							header("HTTP/1.0 406 Unsuport point param");
						}
					}
				}
			}
			else
			{
				header("HTTP/1.0 404 Category Not Found ");
			}
		}
	}

	/**
	 * get all sub categories of the given category
	 */
	public function actionGet()
	{
		$result = array();
		$categoryId = isset($_POST['id']) ? intval($_POST['id']) : null;  
		if($categoryId == 0)
		{
			$categoryId = null;
		}

		$categories = Category::model()->findAllByAttributes(array('parentCategoryId'=>$categoryId));
		foreach($categories as $category)
		{
			$node = array();
			$node['id'] = $category->id;
			$node['text'] = $category->name;
			$node['state'] = $this->has_child($category->id) ? 'closed' : 'open';
			array_push($result, $node);
		}
		echo json_encode($result);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index, create, get, delete, update, move'),
				'roles'=>array('admin'),
			),
			array('deny',
				'actions'=>array('index, create, get, delete, update, move'),
				'users'=>array('*'),
			),
		);
	}

	private function has_child($categoryId)
	{
		$category = Category::model()->findByAttributes(array('parentCategoryId'=>$categoryId));
		if(is_null($category))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	private function is_exist($categoryId)
	{
		$category = Category::model()->findByAttributes(array('id'=>$categoryId));
		if(is_null($category))
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}