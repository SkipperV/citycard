import {useTranslation} from "react-i18next";

export default function Pagination({links, handlePageChange}) {
    const {t} = useTranslation();

    return (
        <nav className="text-center mt-4">
            {links.map((link, index) => {
                const isPrev = index === 0;
                const isNext = index === links.length - 1;

                return (
                    <button
                        onClick={() => {
                            const url = new URL(link.url);
                            handlePageChange(url.searchParams.get('page'));
                            window.scrollTo(0, 0);
                        }}
                        disabled={!link.url || link.active}
                        key={link.label}
                        className={
                            "inline-block py-2 px-3 rounded-lg text-gray-200 " +
                            (link.active ? "bg-gray-950 " : " ") +
                            (!link.url ? "!text-gray-500 " : "hover:bg-gray-950")
                        }
                    >
                        {isPrev && <>&laquo; {t(`pagination.previous`)}</>}
                        {isNext && <>{t(`pagination.next`)} &raquo;</>}
                        {!isPrev && !isNext && link.label}
                    </button>
                );
            })}
        </nav>
    );
}
