<?php

namespace SoftwareGalaxy\NidaClient\Lib\Response;

use SoftwareGalaxy\NidaClient\Exceptions\NidaResponseCodeStatusInvalidException;

class NidaResponseStatusCode
{
    public const STATUS_CODES = [
        ['code' => '000', 'description' => 'Stakeholder Account is ok.'],
        ['code' => '001', 'description' => 'Stakeholder Account does not exist'],
        ['code' => '002', 'description' => 'Stakeholder Account is Suspended'],
        ['code' => '003', 'description' => 'Stakeholder Account has expired'],
        ['code' => '010', 'description' => 'Certificate is ok.'],
        ['code' => '011', 'description' => 'Stakeholder Certificates are not ok.'],
        ['code' => '012', 'description' => 'CIG Certificate is not ok.'],
        ['code' => '020', 'description' => 'Signature Verification Success'],
        ['code' => '021', 'description' => 'Signature Verification fail'],
        ['code' => '030', 'description' => 'Decryption of Key and IV is Success'],
        ['code' => '031', 'description' => 'Decryption of Key not Success'],
        ['code' => '032', 'description' => 'Decryption of IV not Success'],
        ['code' => '040', 'description' => 'Decryption of Payload Success'],
        ['code' => '041', 'description' => 'Decryption of Payload not Success'],
        ['code' => '042', 'description' => 'Payload is not in XML format'],
        ['code' => '050', 'description' => 'This CIG Method is Allowed for you institution'],
        ['code' => '051', 'description' => 'This CIG Method is not allowed for your institution'],
        ['code' => '060', 'description' => 'Phone Number entered is similar to number registered by NIDA'],
        ['code' => '061', 'description' => 'Phone Number entered is different from Number registered by NIDA'],
        ['code' => '060', 'description' => 'OTP has been successfully sent'],
        ['code' => '063', 'description' => 'Failed to send OTP'],
        ['code' => '060', 'description' => 'OTP Verified successfully'],
        ['code' => '064', 'description' => 'Failed to verify OTP'],
        ['code' => '070', 'description' => 'Payload Encrypted Successfully'],
        ['code' => '071', 'description' => 'Failed to Encrypt Payload'],
        ['code' => '080', 'description' => 'Signature Successfully generated'],
        ['code' => '081', 'description' => 'Failed to generate signature'],
        ['code' => '090', 'description' => 'Key and IV Encrypted Successfully'],
        ['code' => '091', 'description' => 'Failed to Encrypt Key'],
        ['code' => '092', 'description' => 'Failed to Encrypt IV'],
        ['code' => '100', 'description' => 'Response XML processed successfully'],
        ['code' => '101', 'description' => 'Failed to process XML Response'],
        ['code' => '102', 'description' => 'No data assigned for this Stakeholder Account'],
        ['code' => '111', 'description' => 'Unable to process XML Payload Request'],
        ['code' => '120', 'description' => 'Success Loaded Question Codes.'],
        ['code' => '121', 'description' => 'Failed to load Question Codes.'],
        ['code' => '122', 'description' => 'Limited number of attempts on answering security questions has been reached.'],
        ['code' => '123', 'description' => 'Previous answer was correct'],
        ['code' => '124', 'description' => 'Previous answer was incorrect TZ_NID_CIG_TECH_API_DOCUMENT CONFIDENTIAL'],
        ['code' => '130', 'description' => 'NIN is valid'],
        ['code' => '131', 'description' => 'NIN is invalid'],
        ['code' => '132', 'description' => 'NIN not Found'],
        ['code' => '140', 'description' => 'Biometric Fingerprint Verification Success'],
        ['code' => '141', 'description' => 'Biometric Fingerprint Verification Failed'],
        ['code' => '142', 'description' => 'Invalid Fingerprint data'],
        ['code' => '143', 'description' => 'Invalid Finger codes'],
        ['code' => '150', 'description' => 'Transaction has successfully verified'],
        ['code' => '151', 'description' => 'Transaction has not successfully verified'],
        ['code' => '152', 'description' => 'Transaction not found'],
        ['code' => '153', 'description' => 'Invalid web method'],
        ['code' => '154', 'description' => 'Invalid Transaction ID'],
        ['code' => '155', 'description' => 'Invalid Stakeholder ID'],
        ['code' => '156', 'description' => 'Missing Input Parameters'],
        ['code' => '160', 'description' => 'Identification Match Found'],
        ['code' => '161', 'description' => 'Identification Match not Found'],
        ['code' => '162', 'description' => 'Unspecified Response from Matching Engine'],
        ['code' => '163', 'description' => 'Wait for Matching Engine to process your request'],
        ['code' => '164', 'description' => 'Request ID not Registered'],
        ['code' => '165', 'description' => 'Payload is missing fingerprint'],
        ['code' => '170', 'description' => 'Alternative to biometric verification allowed for this ID holder'],
        ['code' => '171', 'description' => 'Alternative to biometric verification not allowed for this ID holder'],
        ['code' => '172', 'description' => 'Switch to alternative to biometric verification'],
        ['code' => '00', 'description' => 'General Success'],
        ['code' => '01', 'description' => 'General Failure'],
    ];

    public string $code;

    public string $description;

    /**
     * Make NidaResponseStatusCode instance
     *
     * @throws NidaResponseCodeStatusInvalidException
     */
    public static function make(string $statusCode): self
    {
        $statusCodes = collect(self::STATUS_CODES);
        $_statusCode = $statusCodes->where('code', $statusCode)->first();

        throw_if(
            $_statusCode == null,
            new NidaResponseCodeStatusInvalidException("The status code {$statusCode} passed, is invalid in accordance to NIDA version 3 API")
        );

        $statusCodeInstance = new self;
        $statusCodeInstance->code = $_statusCode['code']??"";
        $statusCodeInstance->description = $_statusCode['description']??"";

        return $statusCodeInstance;
    }
}
