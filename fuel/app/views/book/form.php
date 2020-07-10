<h2>本マスタメンテ</h2>
<?php echo Form::open(); ?>
		<div class="form-group">
			<?php echo Form::label('本ID：', 'bookId', array()); ?> <br>
			<?php echo Form::input('bookId','', array()); ?>
            <?php echo Form::button('search', '検索', array()); ?>
		</div>
        <div class="form-group">
			<?php echo Form::label('本タイトル：', 'bookTitle', array()); ?> <br>
			<?php echo Form::input('bookTitle','', array()); ?>
		</div>
        <div class="form-group">
			<?php echo Form::label('著者名：', 'authorName', array()); ?> <br>
			<?php echo Form::input('authorName','', array()); ?>
		</div>
        <div class="form-group">
			<?php echo Form::label('出版社：', 'publisher', array()); ?> <br>
			<?php echo Form::input('publisher','', array()); ?>
		</div>
        <div class="form-group">
			<?php echo Form::label('出版年月日：', '', array()); ?> <br>
            <?php echo Form::input('publicYear','', array()); ?>年
            <?php echo Form::input('publicMonth','', array()); ?>月
            <?php echo Form::input('publicDay','', array()); ?>日
		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::button('save', '追加', array()); ?>
            <?php echo Form::button('update', '更新', array()); ?>
            <?php echo Form::button('delete', '削除', array()); ?>
            <?php echo Form::button('clear', 'クリア', array()); ?>
		</div>
<?php echo Form::close(); ?>