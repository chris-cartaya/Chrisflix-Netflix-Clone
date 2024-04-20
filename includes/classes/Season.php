<?php
class Season {

    private int $seasonNumber;

    private array $videos;

    // $videos is array of videos for the current season
    public function __construct(int $seasonNumber, array $videos) {
        $this->seasonNumber = $seasonNumber;
        $this->videos = $videos;
    }

    public function getSeasonNumber(): int {
        return $this->seasonNumber;
    }
    
    public function getVideos(): array {
        return $this->videos;
    }

}
?>