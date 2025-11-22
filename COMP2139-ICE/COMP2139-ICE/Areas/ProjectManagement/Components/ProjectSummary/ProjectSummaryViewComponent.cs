using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using COMP2139_ICE.Data;

namespace COMP2139_ICE.Areas.ProjectManagement.Components.ProjectSummary;

public class ProjectSummaryViewComponent : ViewComponent
{
    private readonly ApplicationDbContext _context;

    public ProjectSummaryViewComponent(ApplicationDbContext context)
    {
        _context = context;
    }

    public async Task<IViewComponentResult> InvokeAsync(int projectId)
    {
        var project = await _context.Projects
            // We include tasks so we can count them
            .Include(p => p.ProjectTasks) 
            .FirstOrDefaultAsync(p => p.ProjectId == projectId);

        return View(project);
    }
}