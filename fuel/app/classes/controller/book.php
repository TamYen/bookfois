<?php

class Controller_Book extends Controller
{
    public function action_index()
    {
        $result = array('msg'=>'');
        return View::forge('book/index', $result);
    }

    public function action_search($bookId)
    {
        try {
            $book = Model_Book::find($bookId);
            if ( ! $book) {
                $msg = '本ID'.$bookId.'が見つかりません。'; // MSG0004
                $book = Model_Book::forge();
                $book->book_id = $bookId;
                $result['book'] = $book;
                $result['msg'] = $msg;
                return View::forge('book/index', $result);
            }
            $msg = '本が見つかりました。'; // MSG0003
            $result = array('book'=>$book, 'msg'=>$msg);
            return View::forge('book/index', $result);
        } catch(Exception $e) {
            $book = Model_Book::forge();
            $book->book_id = $bookId;
            $msg = 'サーバー処理で例外が発生しました。'; // MSG0005
            $result = array('book'=>$book, 'msg'=>$msg);
            return View::forge('book/index', $result);
        }
    }

    public function action_create()
    {
        $bookId = Input::post('bookId');
        $bookTitle = Input::post('bookTitle');
        $authorName = Input::post('authorName');
        $publisher = Input::post('publisher');
        $publicYear = Input::post('publicYear');
        $publicMonth = Input::post('publicMonth');
        $publicDay = Input::post('publicDay');
        $publicationDay = $publicYear.'-'.$publicMonth.'-'.$publicDay;

        // クライアントから受け取った本情報
        $book_form = Model_Book::forge();
        $book_form->book_id = $bookId;
        $book_form->book_title = $bookTitle;
        $book_form->author_name = $authorName;
        $book_form->publisher = $publisher;
        $book_form->publication_day = $publicationDay;

        try {
            // 出版年月日が不正日付だった場合
            if ( ! checkdate($publicMonth, $publicDay, $publicYear)) {
                $msg = '出版年月日が不正です。'; // MSG0016
                $result = array('book'=>$book_form, 'msg'=>$msg);
                return View::forge('book/index', $result);
            }
            // 本情報が取得できた場合
            if ($book = Model_Book::find($bookId)) {
                $msg = '本ID'.$bookId.'は登録されています。別のIDを入力してください。'; // MSG0011
                $result = array('book'=>$book_form, 'msg'=>$msg);
                return View::forge('book/index', $result);
            }
            // 本情報が取得できなかった場合
            $val = Model_Book::validate('create');
            if ($val->run()) {
                $query = DB::insert('books')->set(array(
                    'book_id' => $bookId,
                    'book_title' => $bookTitle,
                    'author_name' => $authorName,
                    'publisher' => $publisher,
                    'publication_day' => $publicationDay,
                    'insert_day' => date('Y-m-d H:i:s')
                    ))->execute();
                $msg = '本を登録しました。'; // MSG0012
                $result = array('book'=>$book_form, 'msg'=>$msg);
                return View::forge('book/index', $result);
            } else {
                $msg = 'サーバー処理で例外が発生しました。'; // MSG0005
                $result = array('book'=>$book_form, 'msg'=>$msg);
                return View::forge('book/index', $result);
            }
        } catch (Exception $e) {
            $msg = 'サーバー処理で例外が発生しました。'; // MSG0005
            $result = array('book'=>$book_form, 'msg'=>$msg);
            return View::forge('book/index', $result);
        }
    }

    public function action_update()
    {
        $bookId = Input::post('bookId');
        $bookTitle = Input::post('bookTitle');
        $authorName = Input::post('authorName');
        $publisher = Input::post('publisher');
        $publicYear = Input::post('publicYear');
        $publicMonth = Input::post('publicMonth');
        $publicDay = Input::post('publicDay');
        $publicationDay = $publicYear.'-'.$publicMonth.'-'.$publicDay;

        // クライアントから受け取った本情報
        $book_form = Model_Book::forge();
        $book_form->book_id = $bookId;
        $book_form->book_title = $bookTitle;
        $book_form->author_name = $authorName;
        $book_form->publisher = $publisher;
        $book_form->publication_day = $publicationDay;

        try {
            // 出版年月日が不正日付だった場合
            if ( ! checkdate($publicMonth, $publicDay, $publicYear)) {
                $msg = '出版年月日が不正です。'; // MSG0016
                $result = array('book'=>$book_form, 'msg'=>$msg);
                return View::forge('book/index', $result);
            }

            // 本情報が取得できた場合
            if ($book = Model_Book::find($bookId)) {
                $val = Model_Book::validate('create');
                if ($val->run()) {
                    $book->book_title = $bookTitle;
                    $book->author_name = $authorName;
                    $book->publisher = $publisher;
                    $book->publication_day = $publicationDay;
                    $book->update_day = date('Y-m-d H:i:s');
                    $book->save();

                    $msg = '本を更新しました。'; // MSG0013
                    $result = array('book'=>$book, 'msg'=>$msg);
                    return View::forge('book/index', $result);
                } else {
                    $msg = 'サーバー処理で例外が発生しました。'; // MSG0005
                    $result = array('book'=>$book_form, 'msg'=>$msg);
                    return View::forge('book/index', $result);          
                }
            }

            // 本情報が取得できなかった場合
            $msg = '本ID'.$bookId.'が見つかりません。'; // MSG0014
            $result = array('book'=>$book_form, 'msg'=>$msg);
            return View::forge('book/index', $result); 
        } catch (Exception $e) {
            $msg = 'サーバー処理で例外が発生しました。'; // MSG0005
            $result = array('book'=>$book_form, 'msg'=>$msg);
            return View::forge('book/index', $result);   
        }
    }

    public function action_delete()
    {
        $bookId = Input::post('bookId');
        try {
            $book = Model_Book::find($bookId);

            // 本情報が取得できた場合
            if ($book) {
                $book->delete();
                $msg = '本ID'.$bookId.'を削除しました。'; // MSG0015
                $result = array('msg'=>$msg);
                return View::forge('book/index', $result);    
            }
            
            // 本情報が取得できなかった場合
            $msg = '本ID'.$bookId.'が見つかりません。'; // MSG0014
            $book= Model_Book::forge();
            $book->book_id = $bookId;
            $result = array('book'=>$book, 'msg'=>$msg);
            return View::forge('book/index', $result);   
        } catch (Exception $e) {
            $msg = 'サーバー処理で例外が発生しました。';
            $book= Model_Book::forge();
            $book->book_id = $bookId;
            $result = array('book'=>$book, 'msg'=>$msg);
            return View::forge('book/index', $result); 
        }
    }
}