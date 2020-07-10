<!DOCTYPE html> 
<html lang = "en"> 
    <head> 
        <meta charset = "utf-8"> 
    </head>

    <body>
        <div style='max-width: 600px; margin: auto'>
            <div>
                <h2>本マスタメンテ</h2>
                <div><a href="" onclick="closeCurrentWindow()" style="float: right;">閉じる</a></div>
            </div>
            <?= Form::open(array('id'=>'book_form')); ?>
                <div class="form-group">
                    <?php echo Form::label('本ID：', 'bookId', array()); ?> <br>
                    <?php echo Form::input('bookId', isset($book) ? $book->book_id : '', array('maxlength'=>'4')); ?>
                    <?php echo Form::button('search', '検索', array('onclick'=>'searchBook()', 'type'=>'button', 'style'=>'margin-left: 30px; width: 100px; height: 30px')); ?>
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <?php echo Form::label('本タイトル：', 'bookTitle', array()); ?> <br>
                    <?php echo Form::input('bookTitle', isset($book) ? $book->book_title : '', array('maxlength'=>'40', 'style'=>'width: 600px;')); ?>
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <?php echo Form::label('著者名：', 'authorName', array()); ?> <br>
                    <?php echo Form::input('authorName', isset($book) ? $book->author_name : '', array('maxlength'=>'40', 'style'=>'width: 600px;')); ?>
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <?php echo Form::label('出版社：', 'publisher', array()); ?> <br>
                    <?php echo Form::input('publisher', isset($book) ? $book->publisher : '', array('maxlength'=>'40', 'style'=>'width: 600px;')); ?>
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <?php echo Form::label('出版年月日：', '', array()); ?> <br>
                    <?php echo Form::input('publicYear', isset($book) ? ($book->publication_day != null ? explode('-', $book->publication_day)[0] : '') : '', array('maxlength'=>'4', 'style'=>'width: 100px;')); ?>年
                    <?php echo Form::input('publicMonth', isset($book) ? ($book->publication_day != null ? explode('-', $book->publication_day)[1] : '') : '', array('maxlength'=>'2', 'style'=>'width: 60px;')); ?>月
                    <?php echo Form::input('publicDay', isset($book) ? ($book->publication_day != null ? explode('-', $book->publication_day)[2] : '') : '', array('maxlength'=>'2', 'style'=>'width: 60px;')); ?>日
                </div>
                <div class="form-group" style="margin-top: 20px; float: right;">
                    <label class='control-label'>&nbsp;</label>
                    <?php echo Form::button('save', '追加', array('onclick'=>'addBook()', 'type'=>'button', 'style'=>' width: 100px; height: 30px;')); ?>
                    <?php echo Form::button('update', '更新', array('onclick'=>'updateBook()', 'type'=>'button', 'style'=>'margin-left: 40px; width: 100px; height: 30px;')); ?>
                    <?php echo Form::button('delete', '削除', array('onclick'=>'deleteBook()', 'type'=>'button', 'style'=>'margin-left: 40px; width: 100px; height: 30px;')); ?>
                    <?php echo Form::button('clear', 'クリア', array('onclick'=>'clearForm()', 'type'=>'button', 'style'=>'margin-left: 40px; width: 100px; height: 30px;')); ?>
                </div>
            <?php echo Form::close(); ?>
        </div>
    </body>
    <script>
        var msg = "<?php echo $msg ?>";
        if(msg != ''){
            alert(msg);
        }
        
        var msgIdEmpty = "本IDを入力してください。";
        var msgTitleEmpty = "本タイトルを入力してください。";
        var msgAuthorEmpty = "著者名を入力してください。";
        var msgPublisherEmpty = "出版社を入力してください。";
        var msgPublicDayEmpty = "出版年月日を入力してください。";
        var msgPublicDayNaN = "出版年月日は半角数字で入力してください。";

        var host = 'http://192.168.100.76/book';

        function searchBook() {
            var bookId = document.getElementById('form_bookId').value;
            if (bookId == '') {
                alert('本IDを入力してください。');
            } else {
                var regex = /^[a-z0-9]+$/;
                if (bookId.match(regex) == null) {
                    alert('本IDは半角英数字で入力してください。');
                } else {
                    var url = host + '/search/' + bookId;
                    window.location.href = url;
                }
            }
            // var bookId = document.getElementById("form_bookId").value;
            // var url = 'http://localhost/bookmaster/public/book/search/' + bookId;
            // window.location.href = url;
        }

        function addBook(){
            if (validateBookId()) {
                if ( ! isEmpty('form_bookTitle', msgTitleEmpty)) {
                    if ( ! isEmpty('form_authorName', msgAuthorEmpty)) {
                        if ( ! isEmpty('form_publisher', msgPublisherEmpty)) {
                            if (isNumberAndNotEmpty('form_publicYear', msgPublicDayEmpty, msgPublicDayNaN)) {
                                if (isNumberAndNotEmpty('form_publicMonth', msgPublicDayEmpty, msgPublicDayNaN)) {
                                    if (isNumberAndNotEmpty('form_publicDay', msgPublicDayEmpty, msgPublicDayNaN)) {
                                        document.getElementById("book_form").method = "post";
                                        document.getElementById('book_form').action = host + "/create";
                                        document.getElementById("book_form").submit();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        function updateBook(){
            if (validateBookId()) {
                if ( ! isEmpty('form_bookTitle', msgTitleEmpty)) {
                    if ( ! isEmpty('form_authorName', msgAuthorEmpty)) {
                        if ( ! isEmpty('form_publisher', msgPublisherEmpty)) {
                            if (isNumberAndNotEmpty('form_publicYear', msgPublicDayEmpty, msgPublicDayNaN)) {
                                if (isNumberAndNotEmpty('form_publicMonth', msgPublicDayEmpty, msgPublicDayNaN)) {
                                    if (isNumberAndNotEmpty('form_publicDay', msgPublicDayEmpty, msgPublicDayNaN)) {
                                        document.getElementById("book_form").method = "post";
                                        document.getElementById('book_form').action = host + "/update";
                                        document.getElementById("book_form").submit();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        function deleteBook(){
            if (validateBookId()) {
                document.getElementById("book_form").method = "post";
                document.getElementById('book_form').action = host + "/delete";
                document.getElementById("book_form").submit();
            }
        }

        function validateBookId(){
            var bookId = document.getElementById('form_bookId').value;
            if (bookId == '') {
                alert('本IDを入力してください。');
                return false;
            } else {
                var regex = /^[a-z0-9]+$/;
                if (bookId.match(regex) == null) {
                    alert('本IDは半角英数字で入力してください。');
                    return false;
                }
                return true;
            }
            
        }

        function isEmpty(elementId, msg){
            var text = document.getElementById(elementId).value;
            if (text == '') {
                alert(msg);
                return true
            }
            return false;
        }

        function isNumberAndNotEmpty(elementId, msgEmpty, msgNaN){
            if ( ! isEmpty(elementId, msgEmpty)) {
                var text = document.getElementById(elementId).value;
                var num = parseInt(text);
                if (num == text) {
                    return true;
                }
            }
            alert(msgNaN);
            return false;
        }

        function clearForm(){
            document.getElementById('form_bookId').value = '';
            document.getElementById('form_bookTitle').value = '';
            document.getElementById('form_authorName').value = '';
            document.getElementById('form_publisher').value = '';
            document.getElementById('form_publicYear').value = '';
            document.getElementById('form_publicMonth').value = '';
            document.getElementById('form_publicDay').value = '';
        }

        function closeCurrentWindow(){
            window.close();
        }
   </script>
</html>