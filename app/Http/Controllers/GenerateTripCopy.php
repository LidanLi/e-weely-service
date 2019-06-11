<?php
namespace App\Http\Controllers;
use App\Article;
use App\Day;
use App\Document;
use App\Event;
use App\Person;
use App\Trip;

class GenerateTripCopy extends Controller
{
    public function __invoke(Trip $trip)
    {
        $new = $trip->replicate();
        $new->push();
        $trip->load('people', 'days', 'days.events', 'days.events.contacts', 'days.events.participants', 'days.events.documents', 'articles', 'documents', 'collaborators');
        foreach($trip->getRelation('people') as $people){
            $person = $people->replicate();
            $person->push();
            $new->people()->save($person);
        }
        foreach($trip->getRelation('days') as $days){
            $day = $days->replicate();
            $day->push();
            $new->days()->save($day);
            foreach($day->getRelation('events') as $events){
                $event = $events->replicate();
                $event->push();
                $day->events()->save($event);
                foreach($event->getRelation('contacts') as $econtact){
                    $event->people()->attach($econtact->id, ['is_contact' => 1]);
                }
                foreach($event->getRelation('participants') as $eparticipant){
                    $event->people()->attach($eparticipant->id, ['is_participant' => 1]);
                }
                foreach($event->getRelation('documents') as $edocument){
                    $event->documents()->attach($edocument);
                }
               
            }
        }
        foreach($trip->getRelation('articles') as $articles){
            $article = $articles->replicate();
            $article->push();
            $new->articles()->save($article);
        }
        foreach($trip->getRelation('documents') as $documents){
            $document = $documents->replicate();
            $document->push();
            $new->documents()->save($document);
        }
       
        foreach($trip->getRelation('collaborators') as $collaborator){
            $new->collaborators()->attach($collaborator);
        }
        $new->name = $new->name . " - Copy";
        $new->save();
        return redirect(route('trips.days.index', $new));
    }
}