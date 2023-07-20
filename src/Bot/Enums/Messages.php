<?php

namespace Bot\Enums;

enum Messages
{
    case UnknownCmd;
    case MsgNoSavedPages;
    case MsgSaved;
    case MsgAlreadyExist;
    case MsgHelp;
    case MsgStart;

    public function message(): string
    {
        return match ($this) {
            self::UnknownCmd => "Unknown Command 😬",
            self::MsgNoSavedPages => "You have no saved pages 🙈",
            self::MsgSaved => "Saved! 👌🏼",
            self::MsgAlreadyExist => "You already save have this page in the list 🤓",
            self::MsgHelp => 'I can save and keep your pages. Also i can offer you them to read.

In order to save page, just send me a link to it.

In order to get a random page, just send me a command /rnd
Caution! After read your page will be removed',
            self::MsgStart => 'Hi there! Type /help to see list of commands'
        };
    }
}
