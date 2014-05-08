Feature: Count sent emails
    In order to check if emails were sent
    As a tester
    I want to be able to count sent emails


    Scenario: Count sent emails
        When I send email to "demo@example.com" with message "Hello World!"
        Then 1 mail should be sent
        When I send email to "demo@example.com" with message "Hello World!"
        When I send email to "demo@example.com" with message "Hello World!"
        Then 3 mail should be sent

    Scenario: Count and purge sent emails
        When I send email to "demo@example.com" with message "Hello World!"
        Then 1 mail should be sent
        When I purge mails
        Then 0 mail should be sent
