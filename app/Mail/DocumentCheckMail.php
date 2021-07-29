<?php

namespace Vanguard\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Vanguard\Document;
use Vanguard\DocumentCheck;

class DocumentCheckMail extends Mailable {
    use Queueable, SerializesModels;

    public Document $document;
    public DocumentCheck $document_check;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( Document $document, DocumentCheck $document_check ) {
        $this->document       = $document;
        $this->document_check = $document_check;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $this->subject( $this->document_check->title ?? __( "Document check " . config( 'app.name' ) ) );

        return $this->view( 'mail.document-check' );
    }
}
