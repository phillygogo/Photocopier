 <?php $__env->startSection('content'); ?>
    <div class="photo-title">
        Select an ablum:
    </div>
    <div class="links">
        <?php $__currentLoopData = $PhotoAlbums; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $album): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="/facebook/decision/<?php echo e($album['id']); ?>/<?php echo e($album['name']); ?>"><?php echo e($album['name']); ?></a> <br>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
 <?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>