<?php

// config for SoftwareGalaxy/NIDAClient
return [
    /**
     * The base WSDL route
     */
    'nida_base_wsdl_path' => env('NIDA_BASE_WSDL_PATH', null),

    // *********************************************************
    // ALL PATHS ARE RELATIVE TO YOUR SERVER, NOT ABSOLUTE PATHS
    // IN YOUR SYSTEM
    // *********************************************************

    /**
     * Root CA Certificate (NIDACA)
     *
     * CIG Server CA root
     * certificate for CIG Web
     * Server.
     * Install to cert store: Console
     * Root\Certificates (Local
     * Computer) \ Trusted Root
     * Certification Authorities
     */
    'nida_root_ca_path' => env('NIDA_ROOT_CA_PATH', null),

    /**
     * Sub CA Certificate (NIDASubCA)
     *
     * IG Sub CA root certificate
     * for Stakeholder Certificate
     * Install to cert store: Console
     * Root\Certificates (Local
     * Computer) \ Intermediate
     * Root Certification
     * Authorities
     */
    'nida_sub_ca_path' => env('NIDA_SUB_CA_PATH', null),

    /**
     * Stakeholder Certificate (CSR file)
     *
     * Web Service request/
     * response and generation of
     * stakeholder digital
     * signature.
     * Install to cert store: Console
     * Root\Certificates (Local
     * Computer) \ Personal
     */
    'nida_stakeholder_certificate_path' => env('NIDA_STAKEHOLDER_CERTIFICATE_PATH', null),

    /**
     * Message Security Certificate
     *
     * sed for computation of
     * CIG Web Service request/
     * response and verification of
     * CIG Web Service digital
     * signature.
     * Install to cert store:
     * Console
     * Root\Certificates (Local
     * Computer) \ Personal
     */
    'nida_message_security_ca_path' => env('NIDA_MESSAGE_SECURITY_CA_PATH', null),

    /**
     * Key size and sipher for encryption
     */
    'key_size' => 32,

    'cipher' => 'AES-256-CBC',

    /**
     * The user id provided by NIDA during integration
     */
    'user_id' => env('NIDA_USER_ID', null),
];
