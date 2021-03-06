<?php /* FILEVERSION: v1.0.2b */ ?>
<?php 
class feedFrom{

	public static function tableCur(){
		$table = " ( SELECT `c`.`iso_code` FROM `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "currency_shop` AS `s` INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "currency` AS `c` ON `c`.`id_currency` = `s`.`id_currency` AND `c`.`active` = 1 AND `s`.`id_shop` = 1 LIMIT 0,1 ) AS `cur` ";

		return $table;
	}

	public static function tableA(){
		$join = " INNER JOIN ";
		$table = " `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "product` AS `A` ";
		$on = " ON 1=1 ";

		return $join . $table . $on;
	}

	public static function tableB(){
		$join = " LEFT JOIN ";
		$table = " `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "manufacturer` AS `B` ";
		$on = " ON `A`.`id_manufacturer` = `B`.`id_manufacturer` ";

		return $join . $table . $on;
	}

	public static function tableC(){
		$join = " INNER JOIN ";
		$table = " `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "product_lang` AS `C` ";
		$on = " ON `A`.`id_product` = `C`.`id_product`";

		return $join . $table . $on;
	}

	public static function tableD(){
		$join = " LEFT JOIN ";
		$table = " ( SELECT `url1`.`id_product` AS `id_product` ,`url2`.`link_rewrite` AS `link_rewrite` FROM `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category_product` `url1` INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category_lang` `url2` ON `url1`.`id_category` = `url2`.`id_category` WHERE `url2`.`id_category` NOT IN (1 , 2) GROUP BY `url1`.`id_product` ORDER BY `url1`.`id_product`) AS `D` "; $on = " ON `A`.`id_product` = `D`.`id_product` ";

		return $join . $table . $on;
	}

	public static function tableE(){
		$join = " LEFT JOIN ";
		$table = " (SELECT DISTINCT `prd`.`id_product` AS `id_product`, (LENGTH(CONCAT((CASE WHEN `category_string`.`catName1` IS NULL THEN '' ELSE `category_string`.`catName1` END), (CASE WHEN `category_string`.`catName2` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName2`) END), (CASE WHEN `category_string`.`catName3` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName3`) END), (CASE WHEN `category_string`.`catName4` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName4`) END), (CASE WHEN `category_string`.`catName5` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName5`) END), (CASE WHEN `category_string`.`catName6` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName6`) END), (CASE WHEN `category_string`.`catName7` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName7`) END))) - LENGTH(REPLACE(CONCAT((CASE WHEN `category_string`.`catName1` IS NULL THEN '' ELSE `category_string`.`catName1` END), (CASE WHEN `category_string`.`catName2` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName2`) END), (CASE WHEN `category_string`.`catName3` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName3`) END), (CASE WHEN `category_string`.`catName4` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName4`) END), (CASE WHEN `category_string`.`catName5` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName5`) END), (CASE WHEN `category_string`.`catName6` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName6`) END), (CASE WHEN `category_string`.`catName7` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName7`) END)),' > ','')))AS `levels`,CONCAT((CASE WHEN `category_string`.`catName1` IS NULL THEN '' ELSE `category_string`.`catName1` END), (CASE WHEN `category_string`.`catName2` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName2`) END), (CASE WHEN `category_string`.`catName3` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName3`) END), (CASE WHEN `category_string`.`catName4` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName4`) END), (CASE WHEN `category_string`.`catName5` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName5`) END), (CASE WHEN `category_string`.`catName6` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName6`) END), (CASE WHEN `category_string`.`catName7` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName7`) END)) AS `category_string` FROM (SELECT `crmb1`.`id_category` AS `prd_category1`, `crmb2`.`id_category` AS `prd_category2`, `crmb3`.`id_category` AS `prd_category3`, `crmb4`.`id_category` AS `prd_category4`, `crmb5`.`id_category` AS `prd_category5`, `crmb6`.`id_category` AS `prd_category6`, `crmb7`.`id_category` AS `prd_category7`, `crmb1`.`name` AS `catName1`, `crmb2`.`name` AS `catName2`, `crmb3`.`name` AS `catName3`, `crmb4`.`name` AS `catName4`, `crmb5`.`name` AS `catName5`, `crmb6`.`name` AS `catName6`, `crmb7`.`name` AS `catName7` FROM (SELECT `nam`.`name` AS `name`, `num`.`id_category` AS `id_category`, `num`.`id_parent` AS `id_parent` FROM `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category` `num` INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category_lang` `nam` ON `num`.`id_category` = `nam`.`id_category` WHERE `num`.`active` = 1 AND `num`.`id_parent` = (SELECT `id_category` FROM `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category_lang` WHERE `name` = 'home')) `crmb1` LEFT JOIN (SELECT `nam`.`name` AS `name`, `num`.`id_category` AS `id_category`, `num`.`id_parent` AS `id_parent` FROM `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category` `num` INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category_lang` `nam` ON `num`.`id_category` = `nam`.`id_category` WHERE `num`.`active` = 1) `crmb2` ON `crmb2`.`id_parent` = `crmb1`.`id_category` LEFT JOIN (SELECT `nam`.`name` AS `name`, `num`.`id_category` AS `id_category`, `num`.`id_parent` AS `id_parent` FROM `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category` `num` INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category_lang` `nam` ON `num`.`id_category` = `nam`.`id_category` WHERE `num`.`active` = 1) `crmb3` ON `crmb3`.`id_parent` = `crmb2`.`id_category` LEFT JOIN (SELECT `nam`.`name` AS `name`, `num`.`id_category` AS `id_category`, `num`.`id_parent` AS `id_parent` FROM `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category` `num` INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category_lang` `nam` ON `num`.`id_category` = `nam`.`id_category` WHERE `num`.`active` = 1) `crmb4` ON `crmb4`.`id_parent` = `crmb3`.`id_category` LEFT JOIN (SELECT `nam`.`name` AS `name`, `num`.`id_category` AS `id_category`, `num`.`id_parent` AS `id_parent` FROM `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category` `num` INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category_lang` `nam` ON `num`.`id_category` = `nam`.`id_category` WHERE `num`.`active` = 1) `crmb5` ON `crmb5`.`id_parent` = `crmb4`.`id_category` LEFT JOIN (SELECT `nam`.`name` AS `name`, `num`.`id_category` AS `id_category`, `num`.`id_parent` AS `id_parent` FROM `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category` `num` INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category_lang` `nam` ON `num`.`id_category` = `nam`.`id_category` WHERE `num`.`active` = 1) `crmb6` ON `crmb6`.`id_parent` = `crmb5`.`id_category` LEFT JOIN (SELECT `nam`.`name` AS `name`, `num`.`id_category` AS `id_category`, `num`.`id_parent` AS `id_parent` FROM `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category` `num` INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category_lang` `nam` ON `num`.`id_category` = `nam`.`id_category` WHERE `num`.`active` = 1) `crmb7` ON `crmb7`.`id_parent` = `crmb6`.`id_category` WHERE `crmb1`.`id_category` NOT IN (1 , 2)) `category_string` LEFT JOIN `" . _DB_NAME_ . "`.`mc_cattax_mapping` AS `taxmap` ON `taxmap`.`cattax_merchant_id` = '" . _MERCHANTID_ . "' AND CONCAT((CASE WHEN `category_string`.`catName1` IS NULL THEN '' ELSE `category_string`.`catName1` END), (CASE WHEN `category_string`.`catName2` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName2`) END), (CASE WHEN `category_string`.`catName3` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName3`) END), (CASE WHEN `category_string`.`catName4` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName4`) END), (CASE WHEN `category_string`.`catName5` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName5`) END), (CASE WHEN `category_string`.`catName6` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName6`) END), (CASE WHEN `category_string`.`catName7` IS NULL THEN '' ELSE CONCAT(' > ' , `category_string`.`catName7`) END)) = `taxmap`.`category_string` LEFT JOIN `" . _DB_NAME_ . "`.`mc_taxonomy` AS `tax` ON `tax`.`id` = `taxmap`.`cattax_id` LEFT JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "category_product` `prd` ON `prd`.`id_category` = coalesce(`category_string`.`prd_category7`, `category_string`.`prd_category6`, `category_string`.`prd_category5`, `category_string`.`prd_category4`, `category_string`.`prd_category3`, `category_string`.`prd_category2`, `category_string`.`prd_category1`) GROUP BY `prd`.`id_product` HAVING MAX(`levels`) = `levels` ORDER BY `prd`.`id_product`) AS `E`";
		$on = " ON `A`.`id_product` = `E`.`id_product` ";

		return $join . $table . $on;
	}

	public static function tableF(){
		$join = " LEFT JOIN ";
		$table = " ( SELECT `p`.`id_product`, `sp`.`from`,`sp`.`to`,CAST((CASE WHEN `sp`.`reduction_type` = 'percentage' THEN (`p`.`price`-(`sp`.`reduction`*`p`.`price`)) WHEN `sp`.`reduction_type` = 'amount' THEN (`p`.`price`-`sp`.`reduction`) ELSE '' END) AS DECIMAL(10,2)) AS `sale_price` FROM `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "specific_price` AS `sp` INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "product` AS `p` ON `sp`.`id_product` = `p`.`id_product` WHERE (`sp`.`from` < CURRENT_TIMESTAMP AND `sp`.`to` > CURRENT_TIMESTAMP ) OR (`sp`.`from` = '0000-00-00 00:00:00' AND `sp`.`to` > CURRENT_TIMESTAMP ) OR (`sp`.`from` < CURRENT_TIMESTAMP AND`sp`.`to` = '0000-00-00 00:00:00') ) AS `F` ";
		$on = " ON `A`.`id_product` = `F`.`id_product` ";

		return $join . $table . $on;
	}

	public static function tableImgs($position){

		$a = array();
		
		$join = " LEFT JOIN ";
       	$table = " ( SELECT DISTINCT `i`.`id_product`, `i`.`id_image`, CONCAT('/',CASE WHEN SUBSTRING(`id_image`,1,1) = '' THEN '' ELSE SUBSTRING(`id_image`,1,1)END, CASE WHEN SUBSTRING(`id_image`,2,1) = '' THEN '' ELSE SUBSTRING(`id_image`,2,1)END, CASE WHEN SUBSTRING(`id_image`,3,1) = '' THEN '' ELSE SUBSTRING(`id_image`,3,1)END, CASE WHEN SUBSTRING(`id_image`,4,1) = '' THEN '' ELSE SUBSTRING(`id_image`,4,1)END, CASE WHEN SUBSTRING(`id_image`,5,1) = '' THEN '' ELSE SUBSTRING(`id_image`,5,1)END, CASE WHEN SUBSTRING(`id_image`,6,1) = '' THEN '' ELSE SUBSTRING(`id_image`,6,1)END, '-large_default/',`p`.`link_rewrite`,'.jpg') AS `img` FROM `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "image` AS i INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "product_lang` AS p  ON p.id_product = i.id_product WHERE `i`.`position` = " . $position . " ) AS `img" . $position . "` ";
       	$on = " ON `A`.`id_product` = `img" . $position . "`.`id_product` ";
    
       	array_push($a,$join . $table . $on);
    	
		return implode($a,'');
	}
	public static function tableFeatBuild($version,$feature){
		if($version == "feed"){
			$select = " SELECT DISTINCT `feat_prd`.`id_product`,`feat`.`name`,`feat_val`.`value` AS `" . $feature . "` ";
		} elseif($version == "flist"){
			$select = " SELECT DISTINCT `feat`.`name` AS `Features` ";	
		} elseif($version == "vlist"){
			$select = " SELECT DISTINCT `feat_val`.`value` AS `Values` ";	
		}	elseif($version == "blist"){
			$select = " SELECT DISTINCT `feat`.`name` AS `Features`, `feat_val`.`value` AS `Values` ";	
		}
		
		$from = " FROM `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "feature_lang` `feat` INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "feature_product` `feat_prd` ON `feat`.`id_feature` = `feat_prd`.`id_feature` INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "feature_value_lang` `feat_val` ON `feat_prd`.`id_feature_value` = `feat_val`.`id_feature_value`";
		
		return $select . $from;
	}
	public static function tableFeat($feature){

		$table = "(" . self::tableFeatBuild("feed",$feature) . " WHERE `feat`.`name` = '" . $feature . "') as `" . $feature . "`";
		$join = " LEFT JOIN ";
		$on = " ON `A`.`id_product` = `" . $feature . "`.`id_product` ";

		return $join . $table . $on;
	}
	public static function tableAttrBuild(){
		//table array
		$t = array();

		//table select array, field list array that is used in the result query
		$ts = array();

		//select array
		$s = array();

		//retrieving attribute groups
		$query = mysql_query(getAttrGroups());
		
		//starting counter
		$i=0;

		//adding each attribute group table to query
		while($row = mysql_fetch_array($query)){

			//checking to see if this is the first attribute table, if so there is no on statement necessary
			if($i > 0){
				$join = " LEFT JOIN ";
				$on = "ON `attr" . ($i+1) . "`.`id_product` = `attr1`.`id_product` AND `attr1`.`reference` = `attr" . ($i+1) . "`.`reference`";
			} else {
				$join = "";
				$on = "";
			}

			//setting table select array value
			$tsValue = "`attr" . ($i+1) . "`.`" . $row["group"] . "`";

			//pushing sub select field to table select array
			array_push($ts,$tsValue);

			//setting the table array value
			$v = $join . "(SELECT DISTINCT `l`.`name` AS `" . $row["group"] . "`, `l`.`id_attribute`, CONCAT(`g`.`public_name`,': ',`l`.`name`) AS `title_addition`, `a`.`id_product`,`a`.`reference`
				FROM `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "attribute_group_lang` AS `g`
					INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "attribute` AS `v` ON `v`.`id_attribute_group` = `g`.`id_attribute_group`
					INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "attribute_lang` AS `l` ON `v`.`id_attribute` = `l`.`id_attribute`
					INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "product_attribute_combination` AS `b` ON `b`.`id_attribute` = `l`.`id_attribute`
					INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "product_attribute` AS `a` ON `b`.`id_product_attribute` = `a`.`id_product_attribute`
					WHERE `v`.`id_attribute_group` = " . $row["id"] . ") AS `attr" . ($i+1) . "`" . $on;

			//pushing the table information to the table array
			array_push($t,$v);

			//pushing the select information to the select array
			array_push($s," `attrGroup`.`" . $row["group"] . "`");

			$i++;
		}
		
		//completeing the sub select array
		array_push($ts,"`attr1`.`id_product`,`attr1`.`reference` FROM ");

		$sql = "
		SELECT DISTINCT `a`.`id_product`," . implode(',',$s) . ",
		                `a`.`price` AS `attr_price`,
		                `a`.`weight` AS `attr_weight`,
		                `a`.`id_product_attribute` AS `id_product_ext`,
		                `a`.`reference` AS `new_mpn`
		FROM `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "product_attribute` AS `a`
		INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "product_attribute_combination` AS `b` ON `b`.`id_product_attribute` = `a`.`id_product_attribute`
		INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "attribute`  AS `c` ON `c`.`id_attribute` = `b`.`id_attribute`
		INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "attribute_lang`  AS `d` ON `d`.`id_attribute` = `b`.`id_attribute`
		INNER JOIN `" . _DB_NAME_ . "`.`" . _DB_PREFIX_ . "attribute_group_lang` AS `e` ON `e`.`id_attribute_group` = `c`.`id_attribute_group`

		LEFT JOIN (SELECT DISTINCT " . implode(',',$ts) . implode('',$t) . ") AS `attrGroup`
			ON `attrGroup`.`id_product` = `a`.`id_product`AND `a`.`reference` = `attrGroup`.`reference`
		WHERE  (`a`.`available_date` < CURRENT_TIMESTAMP
		       OR `a`.`available_date` = 0000-00-00)";

		//returning sql
		return $sql;
	}
	public static function tableAttrBase(){
       	$a = array();
       	
        $table = "(" . self::tableAttrBuild() . ") AS `attrSet`";
		$join = " LEFT JOIN ";
		$on = " ON `attrSet`.`id_product` = `A`.`id_product` ";

		array_push($a,$join . $table . $on);
        
        return implode(" ",$a);
    }
    public static function tableOverrideBase(){
    	$a = array();
    	$sql = "SELECT DISTINCT `override_type` FROM `" . _DB_NAME_ . "`.`mc_overrides` WHERE merchant_ID = '" . _MERCHANTID_ . "'";
    	$query = mysql_query($sql);
    	
    	while($rows = mysql_fetch_array($query)){
    		$table = "(SELECT DISTINCT `id_product`, `override_value` AS `override_" . $rows["override_type"] . "` FROM `" . _DB_NAME_ . "`.`mc_overrides` WHERE `override_type` = '" . $rows["override_type"] . "' AND merchant_id = '" . _MERCHANTID_ . "') AS `override_" . $rows["override_type"] . "`";
    		$join = " LEFT JOIN ";
			$on = " ON `override_" . $rows["override_type"] . "`.`id_product` = `A`.`id_product` ";

			array_push($a,$join . $table . $on);
    	}

    	return implode(" ",$a);
	   
    }
	public static function fromConstruct($include){
		if($include == "all"){
			$include = default_functions::allTables();
		} elseif($include == "base"){
			$include = default_functions::standardTables();
		} else {
			$include = feedSelect::selectTables();
		} 
		
		$a = array();

		for($i=0;$i<(count($include));$i++){
			$function = "table" . $include[$i][0];
			$v = self::$function($include[$i][1]);	
			array_push($a,$v);
		}
		
		return " FROM " . implode(" ",array_unique($a,SORT_REGULAR));
	}

//NEW ATTR BUILD
	
}
?>