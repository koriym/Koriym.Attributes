# koriym/attributes

`koriym/attributes` read PHP 8 attributes with doctrine/annotation Reader interface.

Note:  Doctrine annotations are different by design than PHP core one. 
Not all attributes can be read by this reader, and not all PHP8 attributes can be read by this reader.

However, this reader can help you to code forward compatible code that supports both PHP 7.x and 8.x and allows you to use doctrine annotations and php8 attributes at the same time.

## Installation

    composer require koriym/attributes

    
