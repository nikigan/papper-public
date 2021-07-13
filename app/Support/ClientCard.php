<?php


namespace Vanguard\Support;


class ClientCard {
    private string $title;
    private string $link_title;
    private string $link;
    private int $count;


    /**
     * ClientCard constructor.
     *
     * @param string $title
     * @param string $link_title
     * @param string $link
     * @param int $count
     */
    public function __construct(string $title, string $link, string $link_title, int $count) {
        $this->title = $title;
        $this->link_title = $link_title;
        $this->link = $link;
        $this->count = $count;
    }

    public function toArray()
    {
        return [
            'title' => $this->title,
            'link_title' => $this->link_title,
            'link' => $this->link,
            'count' => $this->count
        ];
    }
}
