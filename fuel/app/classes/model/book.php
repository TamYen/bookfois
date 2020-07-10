<?php

class Model_Book extends Orm\Model
{
    // protected static $_table_name = 'books';
    protected static $_primary_key = array('book_id');
    protected static $_properties = array(
        'book_id',
        'book_title',
        'author_name',
        'publisher',
        'publication_day',
        'insert_day',
        'update_day',
    );
    
    public static function validate($name)
    {
        $val = Validation::forge($name);
        $val->add_field('bookId', '本ID', 'required|max_length[4]|valid_string[alpha,numeric]');
        $val->add_field('bookTitle', '本タイトル', 'required|max_length[40]');
        $val->add_field('authorName', '著者名', 'required|max_length[40]');
        $val->add_field('publisher', '出版社', 'required|max_length[40]');
        return $val;
    }
}