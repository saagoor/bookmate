# Models

* Challange
    * Discussion (1)
        - id
        - discussable_type
        - discussable_id
        * Comment (n)
            - id
            - user_id
            - text
            * Comment (n) (Reply)
                - id
                - comment_id
                - user_id
                - text