<?php

use yii\db\Migration;

/**
 * Handles the creation of table `categories`.
 */
class m170618_045851_create_categories_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('categories', [
            'id' => $this->primaryKey(),
            'category' => $this->string(50)->notNull(),
            'slug' => $this->string(100)->notNull(),
            'description' => $this->string(300)->notNull(),
            'feature' => $this->string(300)->notNull()->defaultValue('nofeature.jpg'),
            'parent' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex(
            'idx-categories-slug',
            'categories',
            'slug'
        );

        $column = [
            'category', 'slug', 'description', 'feature'
        ];

        $data = [
            [
                'Appetizer', 'appetizer',
                'Perfect party appetizers the easy way',
                'appetizer.jpg'
            ],
            [
                'Breakfast', 'breakfast',
                'Breakfast is the first meal of a day, most often eaten in the early morning before undertaking the day\'s work.',
                'breakfast.jpg'
            ],
            [
                'Chicken', 'chicken',
                'Find recipes for fried chicken, chicken breast, grilled chicken, chicken wings, and more!',
                'chicken.jpg'
            ],
            [
                'Dessert', 'dessert',
                'Whether you crave sweet, savory, decadent or healthy, we have hundreds of top-rated dessert recipes to satisfy your taste buds.',
                'dessert.jpg'
            ],
            [
                'Healthy', 'healthy',
                'Thousands of delicious healthy recipes, shopping tips and expert advice articles to help you get and stay healthy for life.',
                'healthy.jpg'
            ],
            [
                'Main Dish', 'main-dish',
                'Find healthy, delicious main dish recipes including chicken, fish, vegetable and pasta dishes from the food and nutrition experts at EatingWell.',
                'main-dish.jpg'
            ],
            [
                'Diner', 'dinner',
                'Dinner usually refers to the most significant and important meal of the day, which can be the noon or the evening meal.',
                'dinner.jpg'
            ],
            [
                'Vegetarian', 'vegetarian',
                'Eat mindfully as a vegetarian, vegan recipes and healthy plant-based cooking tips.',
                'vegetarian.jpg'
            ],
            [
                'Beverage', 'beverage',
                'A drink or beverage is a liquid intended for human consumption. In addition to their basic function of satisfying thirst.',
                'beverage.jpg'
            ],
        ];

        $this->batchInsert('categories', $column, $data);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // drops index for column `slug`
        $this->dropIndex(
            'idx-categories-slug',
            'slug'
        );

        $this->dropTable('categories');
    }
}
