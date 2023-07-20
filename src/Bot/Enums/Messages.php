<?php

namespace Bot\Enums;

enum Messages
{
    case UnknownCmd;
    case MsgNoSavedPages;
    case MsgSaved;
    case MsgAlreadyExist;

    public function message(): string
    {
        return match ($this) {
            self::UnknownCmd => "Unknown Command 😬",
            self::MsgNoSavedPages => "You have no saved pages 🙈",
            self::MsgSaved => "Saved! 👌🏼",
            self::MsgAlreadyExist => "You already save have this page in the list 🤓"
        };
    }
}
