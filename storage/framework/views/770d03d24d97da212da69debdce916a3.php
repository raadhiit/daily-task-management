<div class="d-flex align-items-center" x-data>
    <form class="mr-2"
          x-on:submit.prevent="
                $refs.exportBtn.disabled = true;
                var url = window._buildUrl(LaravelDataTables['<?php echo e($tableId); ?>'], 'exportQueue');
                $.get(url + '&exportType=<?php echo e($fileType); ?>&sheetName=<?php echo e($sheetName); ?>&emailTo=<?php echo e(urlencode($emailTo)); ?>').then(function(exportId) {
                    $wire.export(exportId)
                }).catch(function(error) {
                    $wire.exportFinished = true;
                    $wire.exporting = false;
                    $wire.exportFailed = true;
                });
              "
    >
        <button type="submit"
                x-ref="exportBtn"
                :disabled="$wire.exporting"
                class="<?php echo e($class); ?>"
        >Export
        </button>
    </form>

    <?php if($exporting && $emailTo): ?>
        <div class="d-inline">Export will be emailed to <?php echo e($emailTo); ?>.</div>
    <?php endif; ?>

    <?php if($exporting && !$exportFinished): ?>
        <div class="d-inline" wire:poll="updateExportProgress">Exporting...please wait.</div>
    <?php endif; ?>

    <?php if($exportFinished && !$exportFailed && !$autoDownload): ?>
        <span>Done. Download file <a href="#" class="text-primary" wire:click.prevent="downloadExport">here</a></span>
    <?php endif; ?>

    <?php if($exportFinished && !$exportFailed && $autoDownload && $downloaded): ?>
        <span>Done. File has been downloaded.</span>
    <?php endif; ?>

    <?php if($exportFailed): ?>
        <span>Export failed, please try again later.</span>
    <?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\projek\vendor\yajra\laravel-datatables-export\src\resources\views\export-button.blade.php ENDPATH**/ ?>