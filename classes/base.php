<?php
namespace amintado\pay\classes;

interface base {
    /**
     * will init payment private api key
     * @return mixed
     */
    public function initPrivateKey();

    /**
     * init merchance code for pasargad bank
     * @return mixed
     */
    public function initMerchantCode();

    /**
     * init terminal code for pasargad bank
     * @return mixed
     */
    public function initTerminalCode();

    /**
     * will init payment public api key
     * @return mixed
     */
    public function initPublicKey();

    /**
     * The amount to be paid by the seller
     * @return mixed
     */
    public function initAmount();

    /**
     *
     * @return mixed
     */
    public function initInvoiceNumber();

    /**
     * @return mixed
     */
    public function initInvoiceDate();

    /**
     * @return mixed
     */
    public function initDigitalSignature();

    public function initRedirectAddress();

    /**
     * time stamp with "YYYY/MM/DD HH:MM:SS" format
     * @return mixed
     */
    public function initTimestamp();

    /**
     * action field for pasargad bank
     * @return mixed
     */
    public function initAction();


}