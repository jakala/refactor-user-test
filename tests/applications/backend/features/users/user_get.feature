Feature: Find a user
  I want to find a user

  Background:
    Given A valid user with id "a51f82b2-72d7-4a56-b7cd-2a206de24d8d" name "foo" and phone "607111222"

  Scenario: Find a user that exist
    Given I send a "GET" request to "/users/a51f82b2-72d7-4a56-b7cd-2a206de24d8d"
    Then the response status code should be 200
    And the response content should be:
    """
    {
      "id": "a51f82b2-72d7-4a56-b7cd-2a206de24d8d",
      "name": "foo",
      "phone": "607111222"
    }
    """

  Scenario: Find a user that not exist
    Given I send a "GET" request to "/users/0f83c512-b972-411f-9ee5-b5b5cbab7ede"
    Then the response status code should be 404
    And the response should be empty
