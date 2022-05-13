<?php 
    namespace Magistraal\Cron\Messages;

    function find_changes($current_entry) {
        $new_entry = $current_entry;
        $new_items = [];

        // Load top 3 messages
        $messages = \Magistraal\messages\get_all(3);

        // Return if messages could not be loaded
        if(!isset($messages)) {
            return $new_items;
        }
        
        foreach ($messages as $message) {
            // Continue if message is invalid
            if(!isset($message['subject']) || !isset($message['id']) || !isset($message['sender']['name'])) {
                continue;
            }

            // Continue if this message was already discovered
            if(isset($current_entry[$message['id']])) {
                continue;
            }

            // Store the message since it was not yet discovered
            $new_items[] = $message;
            $new_entry[$message['id']] = true;
        }

        return [
            'new_entry' => $new_entry,
            'new_items' => $new_items
        ];
    }
?>