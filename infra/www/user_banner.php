<div class="boundbox">
    <div class="calloutbox rightbox">

        <?php if (empty($user_name)): ?>
        <form method="POST" action="<?php echo htmlspecialchars(strip_tags($_SERVER['PHP_SELF'])); ?>">
            <label for="user_name">Create a username to begin:</label>
            <div class="input_field">
                <input type="text" id="user_name" name="user_name" pattern="[a-zA-Z0-9\-_]+" title="Letters, numbers, dashes and underscores only" autocomplete="off" required>
            </div>
            <button type="submit" class="button">Submit</button>
            <p id="username_check_msg"></p>
        </form>
        <?php else: ?>
        <p><?= $user_message ?></p>
        <?php endif; ?>
    </div>
</div>