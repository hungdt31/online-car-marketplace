<?php
switch ($type) {
  case 'warning':
    $background_color = '#f8d7da';
    $border_color = '#f5c6cb';
    $color = '#721c24';
    $icon = '
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
          <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z" />
          <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
        </svg>
      ';
    break;
  default:
    $background_color = '#FFFFC1';
    $border_color = '#FDB78D';
    $color = '#FDA671';
    $icon = '
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-file-earmark-x" viewBox="0 0 16 16">
          <path d="M6.854 7.146a.5.5 0 1 0-.708.708L7.293 9l-1.147 1.146a.5.5 0 0 0 .708.708L8 9.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 9l1.147-1.146a.5.5 0 0 0-.708-.708L8 8.293z" />
          <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
        </svg>
      ';
    break;
}
?>

<p style="padding: 10px; 
    position: fixed; 
    z-index: 999; 
    background-color: <?= $background_color ?>; 
    color: <?= $color ?>; 
    border: 1px solid <?= $border_color ?>; 
    border-radius: 5px; 
    bottom: 10px;
    right: 10px;
    max-width: 300px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
">
  <?= $icon ?>
  <?= $message ?>
</p>