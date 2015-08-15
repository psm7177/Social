<?php
/**
 * AJAX functions used by UserBoard.
 */
$wgAjaxExportList[] = 'wfSendBoardMessage';
function wfSendBoardMessage( $user_name, $message, $message_type, $count ) {
	global $wgUser;
	$user_name = stripslashes( $user_name );
	$user_name = urldecode( $user_name );
	$user_id_to = User::idFromName( $user_name );
	$b = new UserBoard();

	$m = $b->sendBoardMessage(
		$wgUser->getID(), $wgUser->getName(), $user_id_to, $user_name,
		urldecode( $message ), $message_type
	);

	return $b->displayMessages( $user_id_to, 0, $count );
}

$wgAjaxExportList[] = 'wfDeleteBoardMessage';
function wfDeleteBoardMessage( $ub_id ) {
	global $wgUser;

	$b = new UserBoard();
	if (
		$b->doesUserOwnMessage( $wgUser->getID(), $ub_id ) ||
		$wgUser->isAllowed( 'userboard-delete' )
	) {
		$b->deleteMessage( $ub_id );
	}
	return 'ok';
}

/*
// 새로운 알림 출력 by 페네트
$wgAjaxExportList[] = 'wfGetNewMessage';
function wfGetNewMessage( $ub_old_id ) {
	global $wgUser;

	$b = new UserBoard();
	return $b->getNewMessageCount( $wgUser->getID(), $ub_old_id );
}
$wgAjaxExportList[] = 'wfGetResetNewMessageCount';
function wfGetResetNewMessageCount( $ub_old_id ) {
	global $wgUser;

	$b = new UserBoard();
	return $b->clearNewMessageCount( $wgUser->getID() );
}
*/