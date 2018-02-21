<?php
    require_once('database.php');
    //Gets the category ID
    $category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
    if ($category_id == null || $category_id == false) {
        $category_id = 1; 
    }

    //Gets the name for the selected category
    $queryCategory = 'SELECT * FROM categories 
                    WHERE categoryID = :category_id';
    $statement1 = $db -> prepare($queryCategory);
    $statement1 -> bindValue(':category_id', $category_id);
    $statement1 -> execute();
    $category = $statement1 -> fetch();
    $category_name = $category['name'];
    $statement1 -> closeCursor(); 

    //Get all categories
    $queryAllCategories = 'SELECT * FROM categories 
                        ORDER BY categoryID';
    $statement2 = $db -> prepare($queryAllCategories);
    $statement2 -> execute();
    $categories = $statement2 -> fetchAll();
    $statement2 -> closeCursor(); 

    //Gets products for the selected category
    $queryProducts = 'SELECT * FROM products 
                    WHERE categoryID = :category_id 
                    ORDER BY `name`
                    ';
    $statement3 = $db -> prepare($queryProducts);
    $statement3 -> bindValue(':category_id', $category_id);
    $statement3 -> execute();
    $products = $statement3 -> fetchAll();
    $statement3 -> closeCursor(); 
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>A Bunch of Anime</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <div class="row">
                
                    <main>
                        <div class="col-sm">
                        <aside id="categories">
                            <!-- Displays a list of categories -->
                            <h2>Categories</h2>
                            <nav>
                                <ul>
                                    <?php foreach($categories as $category) : ?>
                                        <li>
                                            <a href="?category_id=<?php echo $category['categoryID']; ?>">
                                                <?php echo $category['name']; ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </nav>
                        </aside>
                        </div>
                        <div class="col-sm">
                        <section>
                            <!-- Displays a table of the products -->
                            <h2><?php $category_name; ?></h2>
                            <table>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th class="right">Price</th>
                                </tr>

                                <?php foreach($products as $product) : ?>
                                    <tr>
                                        <td><?php echo $product['code']; ?></td>
                                        <td><?php echo $product['name']; ?></td>
                                        <td class="right"><?php echo $product['price']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </section>
                        </div>
                    </main>
            </div>
        </div>
    </body>
</html>