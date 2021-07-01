<?php if (isset($msg['content'])): ?>
    <div class="row">
        <div class="col">
            <div class="alert alert-<?=$msg['type']?>" role="alert">
                <?=$msg['content']?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
<?php endif; ?>