<form id="{$Grid.FormId}" class="{if $Grid.FormLayout->isHorizontal()}form-horizontal{/if}" enctype="multipart/form-data" method="POST" action="{$Grid.FormAction}">

    {if not $isEditOperation and $Grid.AllowAddMultipleRecords}
        <div class="btn-group pull-right form-collection-actions">
            <button type="button" class="btn btn-default icon-copy js-form-copy" title={$Captions->GetMessageString('Copy')}></button>
            <button type="button" class="btn btn-default icon-remove js-form-remove" style="display: none" title={$Captions->GetMessageString('Delete')}></button>
        </div>
    {/if}
    <div class="clearfix"></div>

    {include file='common/messages.tpl' type='danger' dismissable=true messages=$Grid.ErrorMessages displayTime=$Grid.MessageDisplayTime}
    {include file='common/messages.tpl' type='success' dismissable=true messages=$Grid.Messages displayTime=$Grid.MessageDisplayTime}

    {if $ShowErrorsOnTop}
        <div class="row">
            <div class="col-md-12 form-error-container form-error-container-top"></div>
        </div>
    {/if}

    {if $isMultiEditOperation}
        {include file='forms/fields_to_be_updated.tpl'}
    {/if}

    {include file='forms/form_fields.tpl' isViewForm=false}

    {include file='forms/form_footer.tpl'}

    {if $flashMessages}
        <input type="hidden" name="flash_messages" value="1" />
    {/if}

    {if $ShowErrorsAtBottom}
        <div class="row">
            <div class="col-md-12 form-error-container form-error-container-bottom"></div>
        </div>
    {/if}

    {include file='forms/form_scripts.tpl'}

</form>