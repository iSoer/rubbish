
    <div>
        <h1><?php echo $title; ?></h1>
    </div>
    <div class="form">
        <?php echo validation_errors(); ?>
        <?php echo form_open('redirect/create') ?>
        
        <label for="url" class="title">Введите url:</label>
        <input name="url" type="text" value="">
        <button>
            Сократить
        </button>
        <?php
            if($status != ''){
                echo '
                    <h2>Новая ссылка:</h2>
                    <a href="http://'.$_SERVER['HTTP_HOST'].'/'.$status.'" target="_blank">
                        http://'.$_SERVER['HTTP_HOST'].'/'.$status.'
                    </a>';
            }

            if( $archive_urls !== NULL && sizeof($archive_urls) > 0){
                $arch = '';
                $i = 0;
                foreach($archive_urls as $key => $val){
                    $arch .= '<a href="http://'.$_SERVER['HTTP_HOST'].'/'.$val['small'].'" target="_blank">'.(++$i).'. '.$_SERVER['HTTP_HOST'].'/'.$val['small'].'</a><br>';
                }
                echo '
                    <h2>Архив ссылок:</h2>
                    <div class="arch">'.$arch.'</div>';
                
            }
        ?>
        </form>
    </div>
