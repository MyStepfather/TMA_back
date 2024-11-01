<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Event;
use App\Models\User;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CardController extends Controller
{

    public function saveCard(Request $request)
    {
        $user = User::query()
            ->where('id', $request->query('userId'))
            ->with('card')
            ->first();

        if ($request->input('first_name')) {
            $user->first_name = isset($user->first_name)
                ? $user->first_name
                : $request->input('first_name')
            ;
        }

        if ($request->input('last_name')) {
            $user->last_name = isset($user->last_name)
                ? $user->last_name
                : $request->input('last_name')
            ;
        }

        if ($request->input('birthday')) {
            $user->birthday = isset($user->birthday)
                ? $user->birthday
                : $request->input('birthday')
            ;
        }

        if ($user->card->count() == 0) {
            $user->first_name = $request->input("first_name");
            $user->last_name = $request->input("last_name");
        }

        $user->save();

        $card = new Card(['user_id' => $user->id]);
        $qr = new QrCodeService;

        $vcard = "BEGIN:VCARD\r\n";
        if ( !empty($user->first_name) && !empty($user->last_name)) {
            $fullname = implode(";", explode(" ", $user->first_name . " " . $user->last_name));
            $vcard .= "N:$fullname;\r\n";
        }

        // if ( !empty($designation) ) {
        //     $vcard .= "TITLE:$designation\r\n";
        // }

        if ( !empty($request->input('company')) ) {
            $company = $request->input('company');
            $vcard .= "ORG:$company\r\n";
        }

        if ( !empty($request->input('phone')) ) {
            $phone = $request->input('phone');
            $vcard .= "TEL;TYPE=mobile:$phone\r\n";
        }

        // if ( !empty($homecontact) ) {
        //     $vcard .= "TEL;TYPE=home,VOICE:$homecontact\r\n";
        // }

        // if ( !empty($mobile) ) {
        //     $vcard .= "TEL;TYPE=work,VOICE:$mobile\r\n";
        // }

        if ( !empty($request->input('email')) ) {
            $email = $request->input('email');
            $vcard .= "EMAIL:$email\r\n";
        }

        if ( !empty($request->input('company_link')) ) {
            $company_link = $request->input('company_link');
            $vcard .= "URL:$company_link\r\n";
        }

        // if ( !empty($address) ) {
        //     $vcard .= "ADR;TYPE=WORK,PREF:;;$address\r\n";
        // }

        $vcard .= "VERSION:3.0\r\n";
        $vcard .= "END:VCARD";
        
        $cardData = [
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'whatsapp_phone' => $request->input('whatsapp_phone'),
            'position' => $request->input('position'),
            'company' => $request->input('company'),
            'company_link' => $request->input('company_link'),
            'qrcode' => (string) \trim($qr->generate($vcard))
        ];

        foreach ($cardData as $key => $value) {
            if (!empty($value)) {
                $card->$key = $value;
            }
        }

        $card->save();

        return response()->json($card);
    }

    public function getCards(Request $request)
    {
        $cards = Card::query()->where('user_id', $request->query('userId'))->get();
        $cards->transform(function ($card) {
            $card->avatar = $card->avatar? URL::to('/'). "/storage/". $card->avatar : null;
            $card['username'] = $card->user->username?? null;
            $card['first_name'] = $card->user->first_name?? null;
            $card['last_name'] = $card->user->last_name?? null;
            $card['birthday'] = $card->user->birthday?? null;
            unset($card->user);
            return $card;
        });

        return response()->json($cards);
    }

    public function updateCard(Request $request, $id)
    {
        $card = Card::query()->find($id);
        if (!$card) {
            return response()->json('Карточка не найдена', 404);
        }
        $card->update($request->all());
        return response()->json($card);
    }

    public function deleteCard($id)
    {
        $card = Card::query()->find($id);
        if (!$card) {
            return response()->json('Карточка не найдена', 404);
        }
        $card?->delete();
        return response()->json('Карточка удалена', 204);
    }
}
