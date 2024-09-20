import {Link} from "@inertiajs/react";

export default function Pagination({links}) {
    return (
        <nav className="text-center mt-4">
            {links.map((link, index) => {
                const isPrev = index === 0;
                const isNext = index === links.length - 1;

                return (
                    <Link
                        as="button"
                        disabled={!link.url || link.active}
                        preserveScroll
                        href={link.url || ""}
                        key={link.label}
                        className={
                            "inline-block py-2 px-3 rounded-lg text-gray-200 " +
                            (link.active ? "bg-gray-950 " : " ") +
                            (!link.url ? "!text-gray-500 " : "hover:bg-gray-950")
                        }
                    >
                        {isPrev && <>&laquo; Назад</>}
                        {isNext && <>Вперед &raquo;</>}
                        {!isPrev && !isNext && link.label}
                    </Link>
                );
            })}
        </nav>
    );
}
