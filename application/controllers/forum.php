<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends MY_Controller
{
    protected $user_model, $message_model;

    public function __construct()
    {
        parent::__construct();

        $this->user_model    = new User();
        $this->message_model = new Message();

        // All paths in this controller require an active, authenticated session
        $this->check_for_login();
    }

    public function index($id = null)
    {
        $this->twig->display('forum/index.html', array(
            'active' => 'forum'
        ));
    }

    public function view($id)
    {
        $message = $this->message_model->get_single_message($id, $this->user('id'));

        if ($message->receiver == $this->user('id')) {
            $mailbox = 'inbox';

            $message->receiver_read_at = date("Y-m-d H:i:s");

            $message->save();

            $message->sender_user = $this->user_model->get_where(array('id' => $message->sender));

            $redirect = base_url('messages/inbox');
        } else {
            $mailbox = 'sent';

            $message->receiver_user = $this->user_model->get_where(array('id' => $message->receiver));

            $redirect = base_url('messages/sent');
        }

        if ($message->exists()) {
            $this->twig->display('messages/view.html', array(
                'message'  => $message,
                'mailbox'  => $mailbox,
                'redirect' => $redirect,
            ));
        } else {
            show_404();
        }
    }

    public function inbox()
    {
        $messages = $this->message_model->order_by('created_at', 'desc')->get_where(array(
            'receiver'            => $this->user('id'),
            'receiver_deleted_at' => null,
        ));

        foreach ($messages as &$message) {
            // Clone the user model to provide a separate instance
            $user_model_instance = clone $this->user_model;

            $message->sender_user = $user_model_instance->get_where(array('id' => $message->sender));
        }

    	$this->twig->display('messages/index.html', array(
            'messages' => $messages,
            'mailbox'  => 'inbox',
            'redirect' => base_url('messages/inbox'),
        ));
    }

    public function sent()
    {
        $messages = $this->message_model->get_where(array(
            'sender'            => $this->user('id'),
            'sender_deleted_at' => null,
        ));

        foreach ($messages as &$message)
            $message->receiver_user = $this->user_model->get_where(array('id' => $message->receiver));

        $this->twig->display('messages/index.html', array(
            'messages' => $messages,
            'mailbox'  => 'sent',
            'redirect' => base_url('messages/sent'),
        ));
    }

    public function send()
    {
    	if ($this->input->is_ajax_request()) {
    		$receiver = $this->user_model;

    		$receiver->where('username', $this->input->post('to', true))->get();

    		if ( ! $receiver->exists()) {
    			$this->json_response(array('status' => 'error', 'message' => 'The user you are trying to send the message to could not be identified'), 404);
    			return;
    		}

    		$message = $this->message_model;

    		$message->receiver = $receiver->id;
    		$message->sender = $this->user('id');

    		$message->subject = $this->input->post('subject', true);
    		$message->message = $this->input->post('message', true);

            $message->created_at = date("Y-m-d H:i:s");

    		$message->save();

    		$this->json_response(array('status' => 'success', 'message' => 'Message sent to ' . $receiver->full_name . ' successfully.'));

    	} else {
    		echo 'This method can only be accessed from ajax';
    	}
    }

    public function delete()
    {
        $now = date("Y-m-d H:i:s");

        if ($this->input->is_ajax_request()) {
            foreach ($this->input->post('messages') as $message_id) {
                $message = $this->message_model->where('id', $message_id)
                    ->group_start()
                        ->where('sender', $this->user('id'))
                        ->or_where('receiver', $this->user('id'))
                    ->group_end()
                ->get();

                if ($message->sender == $this->user('id')) {

                    $message->sender_deleted_at = $now;

                } else {

                    $message->receiver_deleted_at = $now;

                }

                $message->save();

            }

            $s = count($this->input->post('messages'));

            $response_message = $s . ' message' . (($s != 1) ? 's' : '') . ' deleted.';

            $this->session->set_flashdata('alert', array(
                'class' => 'alert-success',
                'message' => $response_message
            ));

            $this->json_response(array('status' => 'success', 'message' => $response_message));
        } else {
            echo 'This method can only be accessed from ajax';
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */