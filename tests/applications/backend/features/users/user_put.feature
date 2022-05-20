Feature: Create a new user
  I want to create a new user

  Scenario: A valid user that not exist
    Given I send a "PUT" request to "/users/9cec71c0-3906-45cc-b8a0-1bd50621c4d5" with body:
    """
    {
      "name": "Diaz",
      "phone": "607123456"
    }
    """
    Then the response should be empty
    And the response status code should be 201

  Scenario: A valid user that exist
    Given I send a "PUT" request to "/users/9cec71c0-3906-45cc-b8a0-1bd50621c4d5" with body:
    """
    {
      "name": "Diaz",
      "phone": "607123456"
    }
    """
    Then the response should be empty
    And the response status code should be 201
